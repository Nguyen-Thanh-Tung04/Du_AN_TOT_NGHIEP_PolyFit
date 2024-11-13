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


        $users = User::where('id', '<>', Auth::user()->id)->get();

        // dd($users);
        // $group_my_chat = GroupchatModel::where('id_leader', '=', Auth::user()->id)
        //     ->select('groupchat.id as groupchatId', 'groupchat.name')
        //     ->get();

        // $group_not_leader = GroupchatModel::leftJoin('groupchat_detail', 'groupchat.id', '=', 'groupchat_detail.groupchat_id')
        //     ->select('groupchat.id as groupchatId', 'groupchat.name')
        //     ->where('groupchat_detail.member_id', Auth::user()->id)->get();

        return view('chat/chat', [
            'users' => $users,
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
        return view('chat.Chat-private-admin', ['users' => $users, 'user' => $user, 'messagePrivate' => $messagePrivate, "id_user_new"=>4]);
    }
    public function search(Request $request)
    {

        if (!empty($request->groupChatId)) {
            $member_id = User::where('groupchat_id', '=', $request->groupChatId)
                ->pluck('member_id')->toArray();
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