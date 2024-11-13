<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\ChatPrivateEvent;
use App\Models\User;
use App\Models\ChatPrivateModel;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        // $users = ChatPrivateModel::join('users', 'message_private.user_send', '=', 'users.id') // Join bảng users với bảng message_private
        // ->where('message_private.created_at', function ($query) {
        //     $query->selectRaw('MAX(created_at)')
        //         ->from('message_private as mp_sub')
        //         ->whereColumn('mp_sub.user_send', 'message_private.user_send'); // So khớp user_send
        // })
        // ->where('users.id', '<>', Auth::user()->id) // Loại trừ người dùng hiện tại
        // ->orderByDesc('message_private.created_at') // Sắp xếp theo thời gian tạo tin nhắn giảm dần
        // ->select('message_private.user_send', 'message_private.message', 'message_private.created_at', 
        //         'users.id as user_id', 'users.name as user_name', 'users.image as user_image')
        // ->get(); // Lấy danh sách người dùng và tin nhắn mới nhất
    
        // dd($users);
        $users = User::where('id', '<>', Auth::user()->id)->get();

        $user = Auth::user();
        // dd($user);

        return view('chat.chat', [
            'users' => $users,
            'user' => $user
            // 'group_my_chat' => $group_my_chat,
            // 'group_not_leader' => $group_not_leader,
        ]);
    }

    public function chatPrivate($idUser)
    {
        // Lấy danh sách người dùng khác (trừ người dùng hiện tại)
        $users = User::where('id', '<>', Auth::user()->id)->get();

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
        return view('chat.Chat-private', ['users' => $users, 'user' => $user, 'messagePrivate' => $messagePrivate]);
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
        $users = User::where('id', '<>', Auth::user()->id)->get();

        // Lấy thông tin người dùng được chỉ định
        $user = User::where('id', '=', $idUser)->first();

        $id_user_new = ChatPrivateModel::join('users', 'message_private.user_send', '=', 'users.id')
            ->whereNull('users.user_catalogue_id') // Điều kiện user_catalogue_id = null
            ->where('message_private.created_at', function ($query) {
                $query->selectRaw('MAX(created_at)')
                    ->from('message_private as mp_sub')
                    ->whereColumn('mp_sub.user_send', 'message_private.user_send'); // So khớp user_send
            })
            ->orderByDesc('message_private.created_at')
            ->select('message_private.user_send', 'message_private.message', 'message_private.created_at', 'users.id as user_id', 'users.name as user_name')
            ->first(); // Lấy bản ghi mới nhất
        // dd($id_user_new);

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
        return view('chat.chat-private-admin', ['users' => $users, 'user' => $user, 'messagePrivate' => $messagePrivate, "id_user_new" => $id_user_new->user_send]);
    }
    public function search(Request $request)
    {

        if (!empty($request->groupChatId)) {
            $member_id = User::all();
            if (!empty($request->search_text)) {
                $result_filter = User::whereIn('id', $member_id)->where('id', '<>', Auth::user()->id)
                    ->where('name', 'like', '%' . $request->search_text . '%')
                    ->get();
            } else {
                $result_filter = User::whereIn('id', $member_id)->where('id', '<>', Auth::user()->id)->get();;
            }
        } else {
            if (!empty($request->search_text)) {
                $result_filter = User::where('name', 'like', '%' . $request->search_text . '%')
                    ->where('id', '<>', Auth::user()->id)
                    ->get();
            } else {
                $result_filter = User::where('id', '<>', Auth::user()->id)->get();
            }
        }

        return response()->json(['data' => $result_filter]);
    }
}
