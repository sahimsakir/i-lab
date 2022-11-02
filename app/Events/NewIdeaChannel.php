<?php

namespace App\Events;

use App\Idea;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewIdeaChannel implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $idea;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Idea $idea)
    {
        $this->idea = $idea;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('new-idea');
    }

    /**
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->idea->id,
            'title' => $this->idea->title,
            'topic' => $this->idea->topic,
            'uuid' => $this->idea->uuid,
            'elevator_pitch' => $this->idea->elevator_pitch,
            'user' => [
                'first_name' => $this->idea->user->first_name,
                'last_name' => $this->idea->user->last_name,
                'uuid' => $this->idea->user->uuid,
            ],
        ];
    }
}
