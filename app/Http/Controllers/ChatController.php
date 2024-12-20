<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\ChatPrivateEvent;
use App\Models\User;
use App\Models\ChatPrivateModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index()
    {
        $authUserId = Auth::user()->id; // ID người dùng hiện tại
        $authUserRole = Auth::user()->user_catalogue_id; // Vai trò người dùng hiện tại
        // $query = ChatPrivateModel::join('users', 'message_private.user_send', '=', 'users.id')
        //     ->where('message_private.created_at', function ($query) {
        //         $query->selectRaw('MAX(created_at)')
        //             ->from('message_private as mp_sub')
        //             ->whereColumn('mp_sub.user_send', 'message_private.user_send');
        //     })
        //     ->where('users.id', '<>', Auth::user()->id)
        //     ->orderByDesc('message_private.created_at')
        //     ->select(
        //         'message_private.user_send',
        //         'message_private.message',
        //         'message_private.is_read',
        //         'message_private.created_at',
        //         'users.id as user_id',
        //         'users.name as user_name',
        //         'users.image as user_image'
        //     );
        // Logic hiển thị tùy theo vai trò
        if ($authUserRole === 1) {
            $users = ChatPrivateModel::join('users as sender', 'message_private.user_send', '=', 'sender.id') // Join bảng users (người gửi)
                ->join('users as receiver', 'message_private.user_reciever', '=', 'receiver.id') // Join bảng users (người nhận)
                ->where('message_private.created_at', function ($query) {
                    $query->selectRaw('MAX(created_at)') // Lấy tin nhắn mới nhất
                        ->from('message_private as mp_sub')
                        ->whereColumn('mp_sub.user_send', 'message_private.user_send')
                        ->whereColumn('mp_sub.user_reciever', 'message_private.user_reciever');
                })
                ->where('sender.id', '<>', Auth::user()->id) // Loại trừ người dùng hiện tại
                ->where('receiver.user_catalogue_id', '2')
                ->orderByDesc('message_private.created_at') // Sắp xếp theo thời gian tạo tin nhắn giảm dần
                ->select(
                    'sender.id as sender_id',
                    'sender.name as sender_name',
                    'sender.image as sender_image',
                    'receiver.id as receiver_id',
                    'receiver.name as receiver_name',
                    'receiver.image as receiver_image',
                    'message_private.message',
                    'message_private.is_read',
                    'message_private.created_at',
                )
                ->get();
        } else {
            // Nếu là nhân viên: Chỉ hiển thị các user đã nhắn tin với tài khoản nhân viên hiện tại
            $users = ChatPrivateModel::join('users', 'message_private.user_send', '=', 'users.id')
                ->where(function ($query) use ($authUserId) {
                    $query->where('message_private.user_reciever', $authUserId)
                        ->orWhere('message_private.user_send', $authUserId);
                })
                ->where('users.id', '<>', $authUserId) // Loại trừ chính nhân viên
                ->groupBy('users.id') // Đảm bảo chỉ lấy thông tin một lần cho từng user
                ->select(
                    'users.id as user_id',
                    'users.name as user_name',
                    'users.image as user_image',
                    DB::raw('(SELECT message FROM message_private 
                          WHERE (user_send = users.id AND user_reciever = ' . $authUserId . ') 
                             OR (user_reciever = users.id AND user_send = ' . $authUserId . ') 
                          ORDER BY created_at DESC LIMIT 1) as message'), // Lấy tin nhắn gần nhất
                    DB::raw('(SELECT created_at FROM message_private 
                          WHERE (user_send = users.id AND user_reciever = ' . $authUserId . ') 
                             OR (user_reciever = users.id AND user_send = ' . $authUserId . ') 
                          ORDER BY created_at DESC LIMIT 1) as created_at'), // Lấy thời gian tạo tin nhắn gần nhất
                    DB::raw('
                          (SELECT is_read 
                           FROM message_private 
                           WHERE (user_send = users.id AND user_reciever = ' . $authUserId . ') 
                              OR (user_reciever = users.id AND user_send = ' . $authUserId . ') 
                           ORDER BY created_at DESC LIMIT 1
                          ) as is_read
                      ')
                )
                ->get();
        }
        $user = Auth::user(); // Lấy thông tin tài khoản hiện tại

        return view('chat.chat', [
            'users' => $users,
            'user' => $user,
        ]);
    }
    public function listChatStaff()
    {
        $users = User::where('users.user_catalogue_id', '2')
            ->select(
                'users.id as user_id',
                'users.name as user_name',
                'users.image as user_image',
                'users.created_at',
            )
            ->get();
        $user = Auth::user(); // Lấy thông tin tài khoản hiện tại

        return view('chat.list-chat-staff', [
            'users' => $users,
            'user' => $user,
        ]);
    }

    public function show($sender_id, $receiver_id)
    {
        $messagePrivate = ChatPrivateModel::join('users as sender', 'message_private.user_send', '=', 'sender.id') // Join bảng users làm sender
            ->join('users as receiver', 'message_private.user_reciever', '=', 'receiver.id') // Join bảng users làm receiver
            ->where(function ($query) use ($sender_id, $receiver_id) {
                $query->where('message_private.user_send', $sender_id)
                    ->where('message_private.user_reciever', $receiver_id);
            })
            ->orWhere(function ($query) use ($sender_id, $receiver_id) {
                $query->where('message_private.user_send', $receiver_id)
                    ->where('message_private.user_reciever', $sender_id);
            })
            ->select(
                'sender.id as sender_id',
                'sender.name as sender_name',
                'sender.image as sender_image',
                'receiver.id as receiver_id',
                'receiver.name as receiver_name',
                'receiver.image as receiver_image',
                'message_private.message',
                'message_private.is_read',
                'message_private.created_at'
            )
            ->get();

        return response()->json(['messagePrivate' => $messagePrivate]);
    }


    public function fetchNewMessages(Request $request)
    {
        $newMessages = ChatPrivateModel::join('users', 'message_private.user_send', '=', 'users.id') // Join bảng users với bảng message_private
            ->where('message_private.created_at', function ($query) {
                $query->selectRaw('MAX(created_at)')
                    ->from('message_private as mp_sub')
                    ->whereColumn('mp_sub.user_send', 'message_private.user_send'); // So khớp user_send
            })
            ->where('users.id', '<>', Auth::user()->id) // Loại trừ người dùng hiện tại
            ->orderByDesc('message_private.created_at') // Sắp xếp theo thời gian tạo tin nhắn giảm dần
            ->select(
                'message_private.user_send',
                'message_private.message',
                'message_private.created_at',
                'users.id as user_id',
                'users.name as user_name',
                'users.image as user_image'
            )
            ->get(); // Lấy danh sách người dùng và tin nhắn mới nhất
        // dd($newMessages);

        return response()->json($newMessages);
    }
    public function chatPrivate($idUser)
    {
        $authUserId = Auth::user()->id; // ID người dùng hiện tại
        ChatPrivateModel::where('user_send', $idUser)
            ->where('user_reciever', $authUserId)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        // Lấy thông tin người dùng được chỉ định
        $user = User::where('id', '=', $idUser)->first();
        // dd($user);

        // Lấy tin nhắn giữa người dùng hiện tại và người dùng được chỉ định
        $messagePrivate = ChatPrivateModel::select(
            'user_send.id as id_user_send',
            'user_send.image as image_user_send',
            'user_reciever.id as id_user_reciever',
            'user_reciever.image as image_user_reciever',
            'message_private.message',
            'message_private.created_at'
        )
            ->leftJoin('users as user_send', 'user_send.id', '=', 'message_private.user_send')
            ->leftJoin('users as user_reciever', 'user_reciever.id', '=', 'message_private.user_reciever')
            ->Where(function ($query) use ($idUser) {
                $query->where('message_private.user_send', $idUser)
                    ->where('message_private.user_reciever', Auth::user()->id);
            })
            ->orWhere(function ($query) use ($idUser) {
                $query->where('message_private.user_send', Auth::user()->id)
                    ->where('message_private.user_reciever', $idUser);
            })
            ->orderBy('message_private.created_at', 'asc') // Đảm bảo tin nhắn được sắp xếp theo thời gian
            ->get();
        // dd($messagePrivate);
        return view('chat.Chat-private', ['user' => $user, 'messagePrivate' => $messagePrivate]);
    }


    public function messagePrivate(Request $request)
    {
        $ChatPrivateModel = new ChatPrivateModel;
        if (!empty($request->idUserReciever) && !empty($request->message)) {
            $ChatPrivateModel->user_send = Auth::user()->id;
            $ChatPrivateModel->user_reciever = $request->idUserReciever;
            $ChatPrivateModel->message = $request->message;
            $ChatPrivateModel->save();
        }
        broadcast(new ChatPrivateEvent($request->user(), User::find($request->idUserReciever), $request->message));
        return response()->json('Thành công');
    }
    public function userInactive(Request $request)
    {
        // Validate the request to ensure `activeUserIds` is an array of integers
        $request->validate([
            'activeUserIds' => 'required|array',
            'activeUserIds.*' => 'integer', // Each item in the array should be an integer
        ]);

        $activeUserIds = $request->activeUserIds;

        // Fetch users whose IDs are not in the array of active user IDs
        $inactiveUsers = User::whereNotIn('id', $activeUserIds)
            ->get()
            ->map(function ($user) {
                // Append full URL for the user image
                $user->image = $user->image ? url($user->image) : 'default-image-path.jpg';
                return $user;
            });

        return response()->json([
            'inactiveUsers' => $inactiveUsers,
            'success' => 'Thành công',
        ]);
    }
    public function chatPrivateAdmin($idUser)
    {
        // Lấy danh sách người dùng khác (trừ người dùng hiện tại)
        $authUserId = Auth::user()->id; // ID người dùng hiện tại
        // Cập nhật trạng thái "đã xem" cho tất cả các tin nhắn gửi đến user hiện tại từ $idUser
        ChatPrivateModel::where('user_send', $idUser)
            ->where('user_reciever', $authUserId)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);
        $authUserRole = Auth::user()->user_catalogue_id; // Vai trò người dùng hiện tại

        // Logic hiển thị tùy theo vai trò
        if ($authUserRole === 1) {
            $users = ChatPrivateModel::join('users', 'message_private.user_send', '=', 'users.id')
                ->where('message_private.user_reciever', $authUserId) // Admin là người nhận
                ->where('users.user_catalogue_id', '2') // Lọc nhân viên (giả sử 2 là nhân viên)
                ->whereIn('message_private.id', function ($query) use ($authUserId) {
                    $query->selectRaw('MAX(id)') // Lấy ID lớn nhất (tin nhắn mới nhất)
                        ->from('message_private')
                        ->where('user_reciever', $authUserId) // Chỉ lấy tin nhắn gửi đến admin
                        ->groupBy('user_send'); // Nhóm theo từng nhân viên
                })
                ->select(
                    'users.id as user_id',
                    'users.name as user_name',
                    'users.image as user_image',
                    'message_private.message',
                    'message_private.created_at',
                    'message_private.is_read'
                )
                ->orderByDesc('message_private.created_at') // Sắp xếp theo thời gian gần nhất
                ->get();
        } elseif ($authUserRole === 2) {
            // Nếu là nhân viên: Chỉ hiển thị các user đã nhắn tin với tài khoản nhân viên hiện tại
            $users = ChatPrivateModel::join('users', 'message_private.user_send', '=', 'users.id')
                ->where(function ($query) use ($authUserId) {
                    $query->where('message_private.user_reciever', $authUserId)
                        ->orWhere('message_private.user_send', $authUserId);
                })
                ->where('users.id', '<>', $authUserId) // Loại trừ chính nhân viên
                ->groupBy('users.id') // Đảm bảo chỉ lấy thông tin một lần cho từng user
                ->select(
                    'users.id as user_id',
                    'users.name as user_name',
                    'users.image as user_image',
                    DB::raw('(SELECT message FROM message_private 
                          WHERE (user_send = users.id AND user_reciever = ' . $authUserId . ') 
                             OR (user_reciever = users.id AND user_send = ' . $authUserId . ') 
                          ORDER BY created_at DESC LIMIT 1) as message'), // Lấy tin nhắn gần nhất
                    DB::raw('(SELECT created_at FROM message_private 
                          WHERE (user_send = users.id AND user_reciever = ' . $authUserId . ') 
                             OR (user_reciever = users.id AND user_send = ' . $authUserId . ') 
                          ORDER BY created_at DESC LIMIT 1) as created_at'), // Lấy thời gian tạo tin nhắn gần nhất
                    DB::raw('(SELECT is_read FROM message_private 
                          WHERE (user_send = users.id AND user_reciever = ' . $authUserId . ') 
                             OR (user_reciever = users.id AND user_send = ' . $authUserId . ') 
                          ORDER BY created_at DESC LIMIT 1) as is_read') // Lấy thời gian tạo tin nhắn gần nhất
                )
                ->get();
        }
        // Lấy thông tin người dùng được chỉ định
        $user = User::where('id', '=', $idUser)->first();

        // Lấy tin nhắn giữa người dùng hiện tại và người dùng được chỉ định
        $messagePrivate = ChatPrivateModel::select(
            'user_send.id as id_user_send',
            'user_send.image as image_user_send',
            'user_reciever.id as id_user_reciever',
            'user_reciever.image as image_user_reciever',
            'message_private.message',
            'message_private.is_read',
            'message_private.created_at'
        )
            ->leftJoin('users as user_send', 'user_send.id', '=', 'message_private.user_send')
            ->leftJoin('users as user_reciever', 'user_reciever.id', '=', 'message_private.user_reciever')
            ->Where(function ($query) use ($idUser) {
                $query->where('message_private.user_send', $idUser)
                    ->where('message_private.user_reciever', Auth::user()->id);
            })
            ->orWhere(function ($query) use ($idUser) {
                $query->where('message_private.user_send', Auth::user()->id)
                    ->where('message_private.user_reciever', $idUser);
            })
            ->orderBy('message_private.created_at', 'asc') // Đảm bảo tin nhắn được sắp xếp theo thời gian
            ->get();
        return view('chat.chat-private-admin', ['users' => $users, 'user' => $user, 'messagePrivate' => $messagePrivate]);
    }
    public function search(Request $request)
    {
        $authUserId = Auth::user()->id;
        $authUserRole = Auth::user()->user_catalogue_id; // Vai trò người dùng hiện tại
        $searchText = $request->search_text;
        // Khởi tạo truy vấn cơ bản
        $query = ChatPrivateModel::join('users', function ($join) {
            $join->on('message_private.user_send', '=', 'users.id')
                ->orOn('message_private.user_reciever', '=', 'users.id');
        })
            ->where(function ($query) {
                $query->where('message_private.user_send', Auth::id())
                    ->orWhere('message_private.user_reciever', Auth::id());
            })
            ->where('users.id', '<>', Auth::id()) // Loại trừ người dùng hiện tại
            ->when($searchText, function ($query, $searchText) {
                // Lọc người dùng theo tên nếu có trường tìm kiếm
                $query->where('users.name', 'like', '%' . $searchText . '%');
            })
            ->groupBy('users.id')
            ->select(
                'users.id as user_id',
                'users.name as user_name',
                'users.image as user_image',
                ChatPrivateModel::raw('MAX(message_private.created_at) as latest_message_time')
            );

        // Nếu là admin, hiển thị tất cả người dùng đã nhắn tin
        if ($authUserRole === 1) {
            // Admin chỉ cần lấy tất cả user đã nhắn tin
            $users = $query->orderByDesc('latest_message_time')->get();
        } else {
            // Nếu là nhân viên, chỉ hiển thị các user đã nhắn tin với nhân viên này
            $users = $query->whereIn('users.id', function ($subQuery) use ($authUserId) {
                $subQuery->select('message_private.user_send')
                    ->from('message_private')
                    ->where('message_private.user_reciever', $authUserId);
            })
                ->orderByDesc('latest_message_time')
                ->get();
        }

        return response()->json(['data' => $users]);
    }

    public function getUnreadMessagesCount()
    {
        $authUserId = Auth::user()->id; // ID người dùng hiện tại
        $authUserRole = Auth::user()->user_catalogue_id; // Vai trò người dùng hiện tại
        if ($authUserRole === 1) {
            // Đếm tin nhắn chưa đọc (Admin xem tất cả)
            $unreadCount = ChatPrivateModel::where('is_read', false)->count();
        } else {
            // Còn Nếu là tk nhân viên: đếm tất nhắn tin chưa đọc với tài khoản nhân viên đó
            $unreadCount = ChatPrivateModel::where('is_read', false)
                ->where(function ($query) use ($authUserId) {
                    $query->where('user_reciever', $authUserId)
                        ->orWhere('user_send', $authUserId);
                })
                ->count();
        }

        return response()->json([
            'unreadCount' => $unreadCount
        ]);
    }
}
