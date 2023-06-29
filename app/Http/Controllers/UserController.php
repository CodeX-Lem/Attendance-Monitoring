<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\ChangeAdminProfileRequest;
use App\Http\Requests\Users\ChangePassRequest;
use App\Http\Requests\Users\ChangeUserProfileRequest;
use App\Http\Requests\Users\StoreUserRequest;
use App\Models\CourseModel;
use App\Models\UserModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
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
                $query->where('username', $this->like, '%' . $search . '%')
                    ->orWhereHas('trainor', function ($query) use ($search) {
                        $query->where('fullname', $this->like, '%' . $search . '%');
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

        $courses =  CourseModel::with('trainor')->get();
        return view('admin.users.create', ['previousUrl' => $previousUrl, 'courses' => $courses]);
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

        $adminUsername = Config::get('adminCredentials.username');
        $adminPassword = Config::get('adminCredentials.password');
        return view('admin.users.change-admin-profile', ['previousUrl' => $previousUrl, 'adminUsername' => $adminUsername, 'adminPassword' => $adminPassword]);
    }

    public function showChangeUserProfile()
    {
        $trainorId = Session::get('trainor_id');
        $user = UserModel::where('trainor_id', $trainorId)->first();
        return view('trainor.users.change-user-profile', ['user' => $user]);
    }

    public function changeUserProfile(ChangeUserProfileRequest $request, $id)
    {
        $validatedData = $request->validated();

        $user = UserModel::find($id);
        $data = ['username' => $validatedData['username'], 'password' => Hash::make($validatedData['password'])];
        $user->update($data);

        Alert::success('Success', 'User credentials has been changed');
        return redirect()->back();
    }

    public function changeAdminProfile(ChangeAdminProfileRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $newUsername = $validatedData['username'];
            $newPassword = $validatedData['password'];
            Config::set('adminCredentials.username', $newUsername);
            Config::set('adminCredentials.password', $newPassword);
            $this->saveConfigToFile('adminCredentials');

            Alert::success('Success', 'Admin credentials has been changed');
        } catch (Exception $e) {
            Alert::error('Error', 'An error occured while changing admin credentials');
        } finally {
            Artisan::call('optimize');
            return redirect()->back();
        }
    }

    private function saveConfigToFile($fileName)
    {
        $configFile = base_path("config/{$fileName}.php");
        $configData = '<?php return ' . var_export(config($fileName), true) . ';';
        file_put_contents($configFile, $configData);
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $adminUsername = Config::get('adminCredentials.username');
        $adminPassword = Config::get('adminCredentials.password');
        if ($username == $adminUsername && $password == $adminPassword) {
            Session::put('isAdmin', true);
            return redirect()->route('admin.dashboard');
        }

        $user = UserModel::where('username', $username)->first();

        if ($user && Hash::check($password, $user->password)) {
            Session::put('isAdmin', false);
            Session::put('trainor_id', $user->trainor_id);
            return redirect()->route('trainor.dashboard');
        }

        return redirect()->back()->with('message', 'Invalid username or password');
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
}
