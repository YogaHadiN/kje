<?php
namespace App\Http\Controllers;

use Input;

use App\Http\Requests;
use App\Models\Classes\Yoga;
use App\Models\User;
use Hash;

class UsersController extends Controller
{



    public function __construct()
    {
        $this->middleware('super', ['only' => ['delete', 'update', 'edit']]);
        $this->middleware('auth', ['except' => ['create', 'store']]);
    }
	/**
	 * Display a listing of users
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::all();

		return view('users.index', compact('users'));
	}

	/**
	 * Show the form for creating a new user
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('users.create');
	}

	/**
	 * Store a newly created user in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		$rules = [
			'username'        => 'required',
			'password'        => 'required',
			'password-repeat' => 'required|same:password',
			'email'           => 'required|unique:users',
			'role'            => 'required'
		];
		$validator = \Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		if ( Input::get('role') == '6' ) {
			$pesan = Yoga::gagalFlash('Tidak bisa membuat Super Admin');
			return redirect()->back()->withPesan($pesan);
		}

		$user = new User;
		$user->email	= Input::get('email');	
		$user->username	= Input::get('username');	
		$user->password	= Hash::make(Input::get('password'));	
		$user->aktif	= Input::get('aktif');	
		$user->role		= Input::get('role');
		$user->save();

		return \Redirect::route('login')->withPesan('User <strong>' . $user->id . ' - ' . $user->username . '</strong> telah <strong>BERHASIL</strong> dibuat,<br /> minta admin untuk mengaktifkan akun anda');
	}

	/**
	 * Show the form for editing the specified user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::find($id);

		return view('users.edit', compact('user'));
	}

	/**
	 * Update the specified user in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$user = User::findOrFail($id);

		$username = $user->username;
		$id = $user->id;

		$rules = [
			'username'        => 'required',
			'password-repeat' => 'same:password',
			'email'           => 'required',
			'role'            => 'required'
		];

		$validator = \Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$user->email	= Input::get('email');	
		$user->username	= Input::get('username');	
        if(Input::has('password'))
        {
            $user->password	= Hash::make(Input::get('password'));
        }	
		$user->email	= Input::get('email');	
		$user->aktif	= Input::get('aktif');	
		$user->role		= Input::get('role');
		$user->save();

		return \Redirect::route('users.index')->withPesan(Yoga::suksesFlash('User <strong>'  . $id . ' - ' . $username .  '</strong> telah <strong>BERHASIL</strong> diubah'));
	}

	/**
	 * Remove the specified user from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $username=User::find($id)->username;
        $confirm = User::destroy($id);
        if ($confirm) {
           $pesan = Yoga::suksesFlash('User <strong>'  . $id . ' - ' . $username .  '</strong> telah <strong>BERHASIL</strong> dihapus'); /* condition */
        } else {
           $pesan = Yoga::gagalFlash('User <strong>'  . $id . ' - ' . $username .  '</strong> telah <strong>GAGAL</strong> dihapus'); /* condition */
        }
		return \Redirect::route('users.index')->withPesan(Yoga::suksesFlash('User <strong>'  . $id . ' - ' . $username .  '</strong> telah <strong>BERHASIL</strong> dihapus'));
	}

}
