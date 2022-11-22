<?php
namespace Project\PHP\Login\Service;

use Project\PHP\Login\Model\UserRegisterRequest;
use Project\PHP\Login\Repository\UserRegisterResponse;
use Project\PHP\Login\Repository\UserRepository;

class UserService
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserRegisterRequest $request) : UserRegisterResponse
    {
        $this->validateUserRegisterRequest($request);
    }

    public function validateUserRegisterRequest(UserRegisterRequest $request)
    {
        if($request->id == null || $request->name == null || $request->password == null ||
        trim($request->id == "") || trim($request->name == "") || trim($request->password == ""));
    }
}