<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Admin\UserRequest;
use Yajra\DataTables\DataTables;
use App\Traits\UploadTrait;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use UploadTrait;

    public function index(Request $request)
    {
        return view('admin.users.index');
    }

    private function makeDatatable($users)
    {
        $now = Carbon::now();

        if (request()->status !== null) {
            if (request()->status) {
                $users->whereNotNull('last_seen')
                    ->where('last_seen', '>=', $now);
            } else {
                $users->where(function($q) use ($now){
                    $q->whereNull('last_seen')
                        ->orWhere('last_seen', '<', $now);
                });
            }
        }

        return DataTables::of($users)
            ->addColumn('status', function ($user) use($now) {
                if ($user->last_seen && $user->last_seen >= $now->subMinutes(5)) {
                    return '<span class="badge bg-success">Online</span>';
                }
                return '<span class="badge bg-danger">Ofline</span>';
            })
            ->filter(function ($users) {
                if (!empty(request()->get('search'))) {
                    $users->where(function($q){
                        $q->where('first_name', 'like', '%'.request()->get('search')['value'].'%')
                            ->orWhere('last_name', 'like', '%'.request()->get('search')['value'].'%');
                    });
                }
            })
			->addColumn('full_name', function($user){
				return $user->full_name;
			})
			->addColumn('orders', function($user){
                return $user->orders()->count();
			})
			->addColumn('action', function($user){
				return view('admin.users.components.action-list', compact('user'))->render();
			})
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(UserRequest $request)
    {
        try {
            $data = $request->validated();
            $data['api_token'] = Str::random(80);
            $user = User::create($data);
            $user->roles()->attach($data['roles']);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Server error',
                'debug' => $th->getMessage()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'redirect' => route('admin.users.index')
        ]);
    }

    public function edit(User $user)
    {
        if (!request()->ajax()){
            return view('admin.users.edit', compact('user'));
        }

        return DataTables::of($user->subscriptions())
			->addColumn('title', function($subscription){
                return $subscription->plan->title;
			})
			->addColumn('period', function($subscription){
                return $subscription->created_at->format('Y-m-d') . ' - ' . $subscription->expire_at->format('Y-m-d');
			})
			->addColumn('interval', function($subscription){
                return $subscription->plan->number_intervals . ' ' . $subscription->plan->interval;
			})
			->addColumn('price', function($subscription){
                return $subscription->plan->price_readable;
			})
			->addColumn('status', function($subscription){
                return $subscription->isActive()
                    ? '<span class="badge badge-success">active</span>' 
                    : '<span class="badge badge-danger">inactive</span>';
			})
            ->rawColumns(['status'])
            ->make(true);
    }

    public function dataTable()
    {
        return $this->makeDatatable(User::query());
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            $data = $request->validated();
            $user->update($data);
            $user->roles()->sync($data['roles']);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'redirect' => route('admin.users.index')
        ]);
    }

    public function destroy(User $user)
    {
        if ($user->id == auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => "Can not delete current user"
            ]);
        }
		$user->delete();

		return response()->json([
            'success' => true,
			'message' => "The user #$user->id successfully deleted!"
        ]);
    }
}