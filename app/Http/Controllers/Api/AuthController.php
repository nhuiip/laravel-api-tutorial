<?php

namespace App\Http\Controllers\Api;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleHasPermission;
use App\Models\UserHasRole;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\ApiController;
use App\Models\User;

class AuthController extends ApiController
{

    public function login(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'email' => 'required|string',
                'password' => 'required|string'
            ]);
            // Check email
            $user = User::where('email', $request->email)->first();
            // Check password
            if (!$user || !Hash::check($request->password, $user->password)) {
                return $this->errorResponse('These credentials do not match our records.', [], 404);
            }
            // Check role
            $role = UserHasRole::where('user_id', $user->id)->first();
            // Check Permission
            $permissions = RoleHasPermission::where('role_id', $role->role_id)->get();
            $hasPermission = array();
            foreach ($permissions as $permission) {
                $permission = Permission::where('id', $permission->permission_id)->first();
                array_push($hasPermission, $permission->name);
            }

            // Create token
            $token = $user->createToken('appToken', $hasPermission)->plainTextToken;

            $response = [
                'user' => $user,
                'role' => Role::find($role->role_id)->name,
                'permissions' => $hasPermission,
                'token' => $token
            ];
            return $this->successResponse('Login success', $response, 200);
        } catch (Exception $ex) {
            switch ($ex->getLine()) {
                case '401':
                    return $this->unauthorizedResponse();
                case '403':
                    return $this->forbiddenResponse();
                    break;
                default:
                    return $this->errorResponse('Something went wrong', $ex->getMessage(), 400);
                    break;
            }
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return $this->successResponse('Logged out', null, 200);
        } catch (Exception $ex) {
            switch ($ex->getLine()) {
                case '401':
                    return $this->unauthorizedResponse();
                case '403':
                    return $this->forbiddenResponse();
                    break;
                default:
                    return $this->errorResponse('Something went wrong', $ex->getMessage(), 400);
                    break;
            }
        }
    }
}
