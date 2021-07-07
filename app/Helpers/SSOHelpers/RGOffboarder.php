<?php

namespace App\Helpers\SSOHelpers;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Storage;

class RGOffboarder extends Helper
{
    protected $group = null;
    public $status = ['success' => true];

    public function __construct($group)
    {
        $this->group = $group;

        $this->checkAttachments();
    }

    public function checkAttachments()
    {
        if (count($this->group->roles) > 0) {
            $this->setStatusToFalse("Resouce Group has is attached to role(s). Please detach it from roles first to delete it");
        }
    }

    public function offboard()
    {
        if ($this->status['success']) {
            if (!is_null($this->group->oauth))
                $this->offboardOauth();

            if (!is_null($this->group->saml))
                $this->offboardSaml();

            $this->group->delete();
            $this->setStatusToTrue("Successfully deleted resource group");
        }
    }

    public function offboardOauth()
    {
        $this->deleteFolderAndContents('Oauth', $this->group->oauth);
        $this->group->oauth->delete();
    }

    public function offboardSaml()
    {
        $this->deleteFolderAndContents('SAML', $this->group->saml);
        $this->group->saml->delete();
    }

    public function deleteFolderAndContents($path, $entity)
    {
        Storage::disk(config('app.storage'))->deleteDirectory("certificates/$path/$entity->folder");
    }

    public function setStatusToFalse($message)
    {
        $this->status = [
            'success' => false,
            'message' => $message
        ];
    }

    public function setStatusToTrue($message)
    {
        $this->status = [
            'success' => true,
            'message' => $message
        ];
    }
}