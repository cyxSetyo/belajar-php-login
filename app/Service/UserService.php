<?php
namespace Project\PHP\Login\Service;

use Exception;
use Project\PHP\Login\Model\UserRegisterRequest;
use Project\PHP\Login\Repository\UserRegisterResponse;
use Project\PHP\Login\Repository\UserRepository;
use Project\PHP\Login\Exception\ValidationException;

class UserService
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserRegisterRequest $request) : UserRegisterResponse
    {
        $this->validateUserRegistrationRequest($request);

        try{
           // $user = $this->userRepository->f
        }catch (\Exception $exception){

        }
    }

    public function validateUserRegistrationRequest(UserRegisterRequest $request)
    {
        if($request->id == null || $request->name == null || $request->password == null ||
        trim($request->id == "") || trim($request->name == "") || trim($request->password == ""))
        {
             throw new ValidationException("Id, User, Password Cant Blank");
        }
    }
}