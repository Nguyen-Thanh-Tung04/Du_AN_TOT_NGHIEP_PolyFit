<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            ->where(function ($query) use ($idUser) {
                $query->where('message_private.user_send', Auth::user()->id)
                    ->where('message_private.user_reciever', $idUser);
            })
            ->orWhere(function ($query) use ($idUser) {
                $query->where('message_private.user_send', $idUser)
                    ->where('message_private.user_reciever', Auth::user()->id);
            })
            ->orderBy('message_private.created_at', 'asc') // Đảm bảo tin nhắn được sắp xếp theo thời gian
            ->get();

        return view('chat.Chat-private', ['users' => $users, 'user' => $user, 'messagePrivate' => $messagePrivate]);
    }
}
