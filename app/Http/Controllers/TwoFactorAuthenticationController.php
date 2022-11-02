<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TwoFactorAuthenticationController extends Controller {
	public function index() {
		return view( 'two-factor-authentication.index' );
	}

	public function store( Request $request ) {
		$validator = Validator::make( $request->all(), [
			'token' => 'required|max:10',
		] );

		if ( $validator->fails() ) {
			return redirect()->back()->withErrors( $validator )->withInput();
		}

		if ( $request->input( 'token' ) == auth()->user()->two_factor_auth_token ) {
			$user                         = auth()->user();
			$user->two_factor_auth_expiry = Carbon::now()->addDays( 30 );
			$user->save();

			return redirect()->route( 'dashboard.index' );
		}

		laraflash()->message( 'Incorrect Two Factor Authentication Code' )->danger();

		return redirect()->route( 'two_factor_authentication.index' );
	}
}
