<?php
namespace Project\PHP\Login\Service;

use Project\PHP\Login\Config\Database;
use Project\PHP\Login\Domain\User;
use Project\PHP\Login\Exception\ValidationException;
use Project\PHP\Login\Model\UserLoginRequest;
use Project\PHP\Login\Model\UserLoginRespone;
use Project\PHP\Login\Model\UserRegisterRequest;
use Project\PHP\Login\Model\UserRegisterResponse;
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

        $this->validateUserRegistrationRequest($request);

        try{
        Database::beginTransaction();
    
        $user = $this->userRepository->findById($request->id);
        if($user != null){
            throw new ValidationException("User Already Exists");
        }

        $user = new User;
        $user->id = $request->id;
        $user->name = $request->name;
        $user->password = password_hash($request->password, PASSWORD_BCRYPT);

        $this->userRepository->save($user);

        $response = new UserRegisterResponse;
        $response->user = $user;

        Database::commitTransaction();
        return $response;
        }catch(\Exception $exception){
            Database::rollbackTransaction();
            throw $exception;
        }
    }
    
    private function validateUserRegistrationRequest(UserRegisterRequest $request)
    {
        if($request->id == null || $request->name == null || $request->password == null ||
        trim($request->id == "") || trim($request->name == "") || trim($request->password == ""))
        {
             throw new ValidationException("Id, User, Password Cant Blank");
        }
    }

    public function login(UserLoginRequest $loginrequest) : UserLoginRespone
    {
        $this->validateUserLoginRequest($loginrequest);

        $user = $this->UserRepository->findById($loginrequest->id);
        if($user == null){
            throw new ValidationException("Id and Password is Wrong");
        }

        if(password_verify($loginrequest->password, $user->password)){
            $loginresponse = new UserLoginRespone;
            $loginresponse->user = $user;
            return $user; 
        }else{
            throw new ValidationException("Id and Password is Wrong");
        }
    }

    private function validateUserLoginRequest(UserLoginRequest $valrequest)
    {
        if($valrequest->id == null || $valrequest->password == null ||
        trim($valrequest->id == "") || trim($valrequest->password == ""))
        {
            throw new ValidationException("Id and Password cant Blank");
        }
    }

}