<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Models\HR\Department;
use App\Models\HR\Employee;

class SearchController extends Controller
{
    /**
     * Global search functionality
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([
                'users' => [],
                'departments' => [],
                'employees' => [],
                'pages' => []
            ]);
        }

        // Search Users
        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->profile_photo_url ?? 'https://via.placeholder.com/32x32.png',
                    'url' => route('hr.employees.show', $user->id)
                ];
            });

        // Search Departments
        $departments = Department::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($department) {
                return [
                    'id' => $department->id,
                    'name' => $department->name,
                    'description' => $department->description,
                    'employees_count' => $department->employees_count ?? 0,
                    'url' => route('hr.departments.show', $department->id)
                ];
            });

        // Search Employees
        $employees = Employee::where('first_name', 'LIKE', "%{$query}%")
            ->orWhere('last_name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('employee_id', 'LIKE', "%{$query}%")
            ->with('department')
            ->limit(5)
            ->get()
            ->map(function ($employee) {
                return [
                    'id' => $employee->id,
                    'name' => $employee->first_name . ' ' . $employee->last_name,
                    'email' => $employee->email,
                    'employee_id' => $employee->employee_id,
                    'department' => $employee->department->name ?? 'No Department',
                    'avatar' => $employee->profile_photo_url ?? 'https://via.placeholder.com/32x32.png',
                    'url' => route('hr.employees.show', $employee->id)
                ];
            });

        // Search Pages (static for now)
        $pages = collect([
            ['name' => 'Mail Settings', 'url' => route('settings.index'), 'icon' => 'mail'],
            ['name' => 'Users & Permissions', 'url' => route('settings.index'), 'icon' => 'users'],
            ['name' => 'Transactions Report', 'url' => '#', 'icon' => 'credit-card'],
            ['name' => 'Employee Management', 'url' => route('hr.employees.index'), 'icon' => 'users'],
            ['name' => 'Department Management', 'url' => route('hr.departments.index'), 'icon' => 'building'],
            ['name' => 'Calendar', 'url' => route('calendar'), 'icon' => 'calendar'],
        ])->filter(function ($page) use ($query) {
            return stripos($page['name'], $query) !== false;
        })->take(5)->values();

        return response()->json([
            'users' => $users,
            'departments' => $departments,
            'employees' => $employees,
            'pages' => $pages,
            'query' => $query
        ]);
    }
}
