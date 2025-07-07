<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            
            $user = $request->user();
            $passwordChanged = false;
    
            // Handle password update if password fields are filled
            if ($request->filled('current_password') || $request->filled('new_password')) {
                // Validate password fields
                $passwordValidated = $request->validate([
                    'current_password' => ['required', 'string'],
                    'new_password' => ['required', 'string', 'min:8', 'confirmed'],
                    'new_password_confirmation' => ['required', 'string'],
                ]);
    
                // Check if current password matches
                if ($request->current_password != $user->password) {
                    throw ValidationException::withMessages([
                        'current_password' => ['The provided password does not match your current password.']
                    ]);
                }
    
                // Update password
                $user->password = $request->new_password;
                $passwordChanged = true;
            }
    
            // Prepare validation rules
            $rules = [
                'age' => ['required', 'integer', 'min:1', 'max:150'],
                'average_grade' => ['required', 'numeric', 'min:0', 'max:100'],
            ];
    
            // Add conditional validation rules for board passer fields
            if ($request->has('is_board_passer')) {
                $rules['board_exam_name'] = ['required', 'string', 'max:255'];
                $rules['board_exam_year'] = ['required', 'integer', 'min:1900', 'max:' . date('Y')];
                $rules['license_number'] = ['required', 'string', 'max:255'];
            } else {
                $rules['board_exam_name'] = ['nullable', 'string', 'max:255'];
                $rules['board_exam_year'] = ['nullable', 'integer', 'min:1900', 'max:' . date('Y')];
                $rules['license_number'] = ['nullable', 'string', 'max:255'];
            }
    
            // Validate fields
            $validated = $request->validate($rules);
    
            // Update user data
            $user->fill([
                'age' => $validated['age'],
                'average_grade' => $validated['average_grade'],
                'act_member' => $request->has('act_member'),
                'leadership' => $request->has('leadership'),
                'is_board_passer' => $request->has('is_board_passer'),
                'board_exam_name' => $validated['board_exam_name'],
                'board_exam_year' => $validated['board_exam_year'],
                'license_number' => $validated['license_number']
            ]);
    
            // Save all changes
            $user->save();
    
            DB::commit();
    
            $message = 'Profile updated successfully!';
            if ($passwordChanged) {
                $message .= ' Your password has been changed.';
            }
    
            return Redirect::route('profile.edit')->with('status', $message);
    
        } catch (ValidationException $e) {
            DB::rollBack();
            return back()
                ->withErrors($e->errors())
                ->withInput($request->except(['current_password', 'new_password', 'new_password_confirmation']));
    
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => 'An error occurred while updating your profile: ' . $e->getMessage()])
                ->withInput($request->except(['current_password', 'new_password', 'new_password_confirmation']));
        }
    }

    /**
     * Get the changes made to the profile
     */
    private function getProfileChanges(array $validated, $user): array
    {
        $changes = [];
        
        foreach ($validated as $field => $value) {
            if ($user->$field != $value) {
                $changes[$field] = [
                    'from' => $user->$field,
                    'to' => $value
                ];
            }
        }
        
        return $changes;
    }
}