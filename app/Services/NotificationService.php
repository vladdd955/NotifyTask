<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\NotificationQueue;
use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class NotificationService
{
    const S_PENDING = 'pending';
    const S_SENT = 'sent';
    const S_FAILED = 'failed';


    protected static array $statuses = [self::S_PENDING, self::S_SENT, self::S_FAILED];
    public function statuses(): array
    {
        return array_combine(self::$statuses, self::$statuses);
    }

    public function createNotify(array $data): Notification
    {
        $user = User::userByEmail($data['email']);

        $notification = Notification::create([
            'user_id' => $user->id,
            'channel' => $data['channel'],
            'message' => $data['message'],
            'status' => self::S_PENDING,
        ]);

        NotificationQueue::notifyQueueCreate($notification);
        return $notification;
    }

    public function createFromTemplate(array $data): Notification
    {
        $template = Template::where('id', $data['template_id'])->first();
        $data['message'] = $template?->message;
        $data['channel'] = $template?->channel;

        return $this->createNotify($data);
    }

    public function userNotify(array $data): Collection
    {
        $user = User::userByEmail($data['email']);

        return Notification::where('user_id', $user->id)->get();
    }

    public function getAllNotify(): Collection
    {
        return Notification::all();
    }

}
