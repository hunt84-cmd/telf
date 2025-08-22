<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Mostrar el formulario de login
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }

    /**
     * Procesar el login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Verificar si el usuario está activo
            if (!$user->isActive()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Tu cuenta ha sido desactivada. Contacta al administrador.',
                ]);
            }

            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))->with('success', 
                '¡Bienvenido, ' . $user->name . '!'
            );
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->withInput($request->only('email'));
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Has cerrado sesión correctamente.');
    }

    /**
     * Mostrar el perfil del usuario
     */
    public function profile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    /**
     * Actualizar el perfil del usuario
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Cambiar contraseña si se proporciona
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * Crear usuario administrador por defecto
     */
    public static function createDefaultAdmin()
    {
        if (!User::where('email', 'admin@emisoras.com')->exists()) {
            User::create([
                'name' => 'Administrador',
                'email' => 'admin@emisoras.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_active' => true,
            ]);
        }
    }
}