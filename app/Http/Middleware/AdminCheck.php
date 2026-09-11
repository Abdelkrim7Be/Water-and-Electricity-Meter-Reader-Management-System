<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminCheck
{
    private const PERMISSIONS = [
        'addReleveur' => ['releveurs', 'write'],
        'getReleveur' => ['releveurs', 'read'],
        'editReleveur' => ['releveurs', 'update'],
        'deleteReleveur' => ['releveurs', 'delete'],
        'addPlan' => ['releves', 'write'],
        'getPlan' => ['releves', 'read'],
        'editPlan' => ['releves', 'update'],
        'deletePlan' => ['releves', 'delete'],
        'createUser' => ['adminusers', 'write'],
        'getUsers' => ['adminusers', 'read'],
        'editUser' => ['adminusers', 'update'],
        'deleteUser' => ['adminusers', 'delete'],
        'getHistorique' => ['historique', 'read'],
        'clearHistorique' => ['historique', 'delete'],
        'createRole' => ['roles', 'write'],
        'editRole' => ['roles', 'update'],
        'deleteRole' => ['roles', 'delete'],
        'assignRole' => ['assignRole', 'update'],
        'image' => ['releveurs', 'read'],
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['msg' => 'Authentification requise.'], 401);
        }

        $role = $user->role;
        $method = $request->route()->getActionMethod();
        $allowed = match ($method) {
            'stats' => $role && $role->hasAnyPermission('read'),
            'getRoles' => $role && ($role->allows('roles', 'read') || $role->allows('adminusers', 'read') || $role->allows('assignRole', 'read')),
            'releveurOptions' => $role && ($role->allows('releves', 'write') || $role->allows('releves', 'update')),
            'upload', 'deleteImage' => $role && ($role->allows('releveurs', 'write') || $role->allows('releveurs', 'update')),
            default => isset(self::PERMISSIONS[$method]) && $role && $role->allows(...self::PERMISSIONS[$method]),
        };

        abort_unless($allowed, 403, 'Permission insuffisante.');
        return $next($request);
    }
}
