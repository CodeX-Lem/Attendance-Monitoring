<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\ChangeAdminProfileRequest;
use App\Http\Requests\Users\ChangePassRequest;
use App\Http\Requests\Users\StoreUserRequest;
use App\Models\UserModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $entries = $request->input('entries', 5);

        $users = UserModel::with(['trainor' => function ($query) {
            $query->select('id', 'fullname');
        }])
            ->where(function ($query) use ($search) {
                $query->where('username', 'like', '%' . $search . '%')
                    ->orWhereHas('trainor', function ($query) use ($search) {
                        $query->where('fullname', 'like', '%' . $search . '%');
                    });
            })
            ->paginate($entries);
        $currentPage = $users->currentPage();
        $lastPage = $users->lastPage();

        if ($currentPage > $lastPage) {
            $redirect = redirect()->route('admin.users.index', [
                'page' => $lastPage,
                'entries' => $entries,
                'search' => $search,
            ]);


            if ($request->session()->has('type') && $request->session()->has('message')) {
                $type = $request->session()->get('type');
                $message = $request->session()->get('message');
                $redirect = $redirect->with('type', $type)->with('message', $message);
            }

            return $redirect;
        }
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('admin.users.index', ['users' => $users]);
    }

    public function create()
    {
        $previous = URL::previous();
        $current = URL::current();
        $previousUrl = $previous == $current ? route('admin.users.index') : $previous;
        return view('admin.users.create', ['previousUrl' => $previousUrl]);
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $data = [
                'username' => $validatedData['username'],
                'password' => Hash::make($validatedData['password']),
                'trainor_id' => $validatedData['trainor_id'],
            ];

            UserModel::create($data);
            Alert::success('Success', 'New user has been added');
        } catch (Exception $e) {
            Alert::error('Error', 'An error occured while adding the user');
        } finally {
            return redirect($request->input('previous_url'));
        }
    }

    public function changePassShow($id)
    {
        $previous = URL::previous();
        $current = URL::current();
        $previousUrl = $previous == $current ? route('admin.users.index') : $previous;

        return view('admin.users.changepass', ['previousUrl' => $previousUrl, 'userId' => $id]);
    }

    public function changePass(ChangePassRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $data = ['password' => Hash::make($validatedData['password'])];
            $user = UserModel::where('id', '=', $id)->first();
            $user->update($data);
            Alert::success('Success', 'Password has been changed');
        } catch (Exception $e) {
            Alert::error('Error', 'An error occured while change the password');
        } finally {
            return redirect($request->input('previous_url'));
        }
    }

    public function destroy($id)
    {
        try {
            $user = UserModel::findorfail($id);

            if ($user->role == 1) {
                Alert::error('Error', 'Cannot remove admin account');
                return redirect()->back();
            }

            $user->delete();
            Alert::success('Success', 'User has been removed');
        } catch (Exception $e) {
            Alert::error('Error', 'An error occured while removing the user');
        } finally {
            return redirect()->back();
        }
    }

    public function showChangeAdminProfile()
    {
        $previous = URL::previous();
        $current = URL::current();
        $previousUrl = $previous == $current ? route('admin.users.index') : $previous;

        $adminUsername = env('ADMIN_USERNAME');
        $adminPassword = env('ADMIN_PASSWORD');
        return view('admin.users.change-admin-profile', ['previousUrl' => $previousUrl, 'adminUsername' => $adminUsername, 'adminPassword' => $adminPassword]);
    }

    public function changeAdminProfile(ChangeAdminProfileRequest $request)
    {
        try {
            $adminUsername = $request->input('username');
            $adminPassword = $request->input('password');

            // Update the values in the configuration
            config(['app.admin_username' => $adminUsername]);
            config(['app.admin_password' => $adminPassword]);

            // Persist the changes in the .env file
            $this->updateEnvFile('ADMIN_USERNAME', $adminUsername);
            $this->updateEnvFile('ADMIN_PASSWORD', $adminPassword);

            // Clear the config cache to reflect the changes
            Artisan::call('config:clear');

            Alert::success('Success', 'Admin credentials has been changed');
        } catch (Exception $e) {
            Alert::error('Error', 'An error occured while changing admin credentials');
        } finally {
            return redirect()->back();
        }
    }

    private function updateEnvFile($key, $value)
    {
        $envFile = base_path('.env');

        if (file_exists($envFile)) {
            file_put_contents($envFile, str_replace(
                $key . '=' . env($key),
                $key . '=' . $value,
                file_get_contents($envFile)
            ));
        }
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $adminUsername = env('ADMIN_USERNAME', 'admin');
        $adminPassword = env('ADMIN_PASSWORD', '12345678');
        if ($username == $adminUsername && $password == $adminPassword) {
            Session::put('isAdmin', true);
            return redirect()->route('admin.dashboard');
        }

        $user = UserModel::where('username', $username)->first();

        if ($user && Hash::check($password, $user->password)) {
            Session::put('isAdmin', false);
            return 'User is regular';
        }

        return redirect()->back()->with('message', 'Invalid username or password');
    }

    public function logout()
    {
        if (Session::has('isAdmin')) {
            Session::pull('isAdmin');
            return redirect('/');
        }
    }
}
