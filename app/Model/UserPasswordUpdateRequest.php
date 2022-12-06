<?php
namespace Project\PHP\Login\Model;

class UserUpdatePasswordRequest
{
    public ?string $id = null;
    public ?string $oldPassword = null;
    public ?string $newPassword = null;
}