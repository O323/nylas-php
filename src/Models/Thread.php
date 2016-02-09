<?php

namespace Nylas\Models;

use Nylas\NylasAPIObject;
use Nylas\NylasModelCollection;

class Thread extends NylasAPIObject
{
    public $collectionName = 'threads';

    public function __construct($api)
    {
        parent::__construct();
        $this->api = $api;
        $this->namespace = null;
    }

    public function messages()
    {
        $thread_id = $this->data['id'];
        $msgObj = new Message($this);

        return new NylasModelCollection($msgObj, $this->klass, null, ['thread_id' => $thread_id], 0, []);
    }

    public function drafts()
    {
        $thread_id = $this->data['id'];
        $msgObj = new Draft($this);

        return new NylasModelCollection($msgObj, $this->klass, null, ['thread_id' => $thread_id], 0, []);
    }

    public function createReply()
    {
        return $this->drafts()->create(['subject'        => $this->data['subject'],
                                             'thread_id' => $this->data['id'], ]);
    }

    public function addTags($tags)
    {
        return $this->_updateTags($tags);
    }

    public function removeTags($tags)
    {
        return $this->_updateTags([], $tags);
    }

    public function markAsRead()
    {
        return $this->_updateTags([], ['unread']);
    }

    public function markAsSeen()
    {
        return $this->_updateTags([], ['unseen']);
    }

    public function archive()
    {
        return $this->_updateTags(['archive'], ['inbox']);
    }

    public function unarchive()
    {
        return $this->_updateTags(['inbox'], ['archive']);
    }

    public function trash()
    {
        return $this->_updateTags(['trash'], []);
    }

    public function star()
    {
        return $this->_updateTags(['starred'], []);
    }

    public function unstar()
    {
        return $this->_updateTags([], ['starred']);
    }

    private function _updateTags($add = [], $remove = [])
    {
        $payload = ['add_tags'         => $add,
                         'remove_tags' => $remove, ];

        return $this->api->klass->_updateResource($this->namespace, $this, $this->data['id'], $payload);
    }
}
