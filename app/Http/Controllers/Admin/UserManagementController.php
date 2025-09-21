<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\File;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = User::query();

            // Search functionality
            if ($search = $request->input('search')) {
                $query->where(function($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('middle_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('degree_name', 'like', "%{$search}%");
                });
            }

            // Role filter
            if ($roles = $request->input('roles')) {
                $query->whereIn('role', $roles);
            }

            // Verification status filter
            if ($request->has('verified')) {
                if ($request->input('verified') === '1') {
                    $query->whereNotNull('email_verified_at');
                } else {
                    $query->whereNull('email_verified_at');
                }
            }

            // Sorting
            switch ($request->input('sort')) {
                case 'oldest':
                    $query->oldest();
                    break;
                case 'name':
                    $query->orderBy('first_name')->orderBy('last_name');
                    break;
                default:
                    $query->latest();
                    break;
            }

            $users = $query->paginate(10)->withQueryString();
            return view('admin.users.index', compact('users'));

        } catch (\Exception $e) {
            Log::error('User listing error: ' . $e->getMessage());
            return back()->with('error', 'Error loading users: ' . $e->getMessage());
        }
    }

    public function edit(User $user)
    {
        try {
            return view('admin.users.edit', compact('user'));
        } catch (\Exception $e) {
            Log::error('User edit error: ' . $e->getMessage());
            return back()->with('error', 'Error loading user details: ' . $e->getMessage());
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:100',
                'middle_name' => 'nullable|string|max:100',
                'last_name' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'degree_name' => 'required|string|max:100',
                // 'role' => 'required|in:user,recruiter,admin', // Remove or make optional if not in form
            ]);

            $user->update($validated);

            // Log the successful update
            Log::info("User updated successfully: {$user->id}");

            return redirect()->route('admin.users.index')
                ->with('success', 'User updated successfully');

        } catch (\Exception $e) {
            Log::error('User update error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Error updating user: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            
            // Log the successful deletion
            Log::info("User deleted successfully: {$user->id}");

            return redirect()->route('admin.users.index')
                ->with('success', 'User deleted successfully');

        } catch (\Exception $e) {
            Log::error('User deletion error: ' . $e->getMessage());
            return back()->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|unique:users,student_id',
                'first_name' => 'required|string|max:100',
                'middle_name' => 'nullable|string|max:100',
                'last_name' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email',
                'degree_name' => 'required|string|max:100',
                'birthday' => 'required|date',
            ]);

            // Generate username and password from ID and birthday
            $birthday = new \DateTime($request->birthday);
            $username = $validated['id'];
            $password = $username . $birthday->format('m/d/y');

            // Calculate age
            $today = new \DateTime();
            $age = $birthday->diff($today)->y;

            // Create user with generated credentials and calculated age
            $user = User::create([
                'student_id' => $validated['id'],
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'password' => $password,
                'degree_name' => $validated['degree_name'],
                'age' => $age, // Add the calculated age
            ]);

            Log::info("User created successfully: {$user->id}");
            return response()->json([
                'message' => 'User created successfully',
                'username' => $username,
                'password' => $password
            ]);

        } catch (\Exception $e) {
            Log::error('User creation error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error creating user: ' . $e->getMessage()
            ], 422);
        }
    }

    public function updateUser(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|unique:users,student_id,' . $user->id,
                'first_name' => 'required|string|max:100',
                'middle_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'degree_name' => 'required|string|max:100',
                'birthday' => 'required|date',
            ]);

            // If the ID is changed, update it
            if ($user->student_id !== $validated['id']) {
                $user->student_id = $validated['id'];
            }

            // Generate new password if birthday is changed
            if ($request->filled('birthday')) {
                $birthday = new \DateTime($request->birthday);
                $username = $validated['id'];
                $password = $username . $birthday->format('m/d/y');
                $validated['password'] = $password;
            }

            $user->update($validated);

            Log::info("User updated successfully: {$user->id}");
            return response()->json([
                'message' => 'User updated successfully',
                'password' => $password ?? null
            ]);

        } catch (\Exception $e) {
            Log::error('User update error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error updating user: ' . $e->getMessage()
            ], 422);
        }
    }

    public function show(User $user)
    {
        try {
            return view('admin.users.show', compact('user'));
        } catch (\Exception $e) {
            Log::error('User view error: ' . $e->getMessage());
            return back()->with('error', 'Error loading user details: ' . $e->getMessage());
        }
    }

    public function uploadCsv(Request $request)
    {
        try {
            $request->validate([
                'csvFile' => 'required|file|mimes:csv,xlsx,xls|max:10240'
            ]);

            \Log::info('CSV upload started', [
                'fileName' => $request->file('csvFile')->getClientOriginalName(),
                'fileSize' => $request->file('csvFile')->getSize()
            ]);

            // Create temporary directory for CSV processing
            $tempDir = sys_get_temp_dir() . '/user_csv_upload_' . uniqid();
            if (!File::exists($tempDir)) {
                File::makeDirectory($tempDir, 0755, true, true);
            }

            $file = $request->file('csvFile');
            $tempCsvPath = $tempDir . '/users.csv';

            // Convert Excel to CSV if needed
            if ($file->getClientMimeType() !== 'text/csv') {
                $spreadsheet = IOFactory::load($file->getPathname());
                $writer = IOFactory::createWriter($spreadsheet, 'Csv');
                $writer->save($tempCsvPath);
            } else {
                $file->move($tempDir, 'users.csv');
            }

            // Read CSV file
            $csvData = [];
            if (($handle = fopen($tempCsvPath, 'r')) !== FALSE) {
                $header = fgetcsv($handle); // Skip header row
                \Log::info('CSV Header', ['header' => $header]);
                
                $rowCount = 0;
                while (($data = fgetcsv($handle)) !== FALSE) {
                    $csvData[] = $data;
                    $rowCount++;
                }
                fclose($handle);
                
                \Log::info('CSV Data loaded', ['rowCount' => $rowCount]);
            } else {
                throw new \Exception('Could not read CSV file');
            }

            // Column mapping from CSV headers to database columns
            $columnMapping = [
                'ID Number' => 'id',
                'First Name' => 'first_name',
                'Middle Name' => 'middle_name',
                'Last Name' => 'last_name',
                'Degree' => 'degree_name',
                'Birthday' => 'birthday',
                'Email' => 'email'
            ];

            // Start database transaction
            DB::beginTransaction();

            try {
                $insertedCount = 0;
                $errorCount = 0;
                $errors = [];
                $generatedCredentials = [];

                // Process each row
                foreach ($csvData as $rowIndex => $row) {
                    try {
                        $userData = [];
                        
                        // Map CSV columns to database columns
                        foreach ($columnMapping as $csvColumn => $dbColumn) {
                            $columnIndex = array_search($csvColumn, $header);
                            if ($columnIndex !== false && isset($row[$columnIndex])) {
                                $value = trim($row[$columnIndex]);
                                
                                // Handle empty values
                                if ($value === '' || $value === null) {
                                    $userData[$dbColumn] = null;
                                    continue;
                                }
                                
                                $userData[$dbColumn] = $value;
                            }
                        }

                        // Validate required fields
                        if (empty($userData['id']) || empty($userData['first_name']) || 
                            empty($userData['last_name']) || empty($userData['email']) || 
                            empty($userData['degree_name']) || empty($userData['birthday'])) {
                            $errors[] = "Row " . ($rowIndex + 2) . ": Missing required fields (ID Number, First Name, Last Name, Email, Degree, Birthday)";
                            $errorCount++;
                            continue;
                        }

                        // Check if user already exists
                        if (User::where('student_id', $userData['id'])->exists()) {
                            $errors[] = "Row " . ($rowIndex + 2) . ": User with ID {$userData['id']} already exists";
                            $errorCount++;
                            continue;
                        }

                        if (User::where('email', $userData['email'])->exists()) {
                            $errors[] = "Row " . ($rowIndex + 2) . ": User with email {$userData['email']} already exists";
                            $errorCount++;
                            continue;
                        }

                        // Generate username and password from ID and birthday
                        // Handle different date formats (DD/MM/YYYY or YYYY-MM-DD)
                        $birthdayStr = $userData['birthday'];
                        if (strpos($birthdayStr, '/') !== false) {
                            // Convert DD/MM/YYYY to YYYY-MM-DD
                            $dateParts = explode('/', $birthdayStr);
                            if (count($dateParts) === 3) {
                                $birthdayStr = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];
                            }
                        }
                        
                        $birthday = new \DateTime($birthdayStr);
                        $username = $userData['id'];
                        $password = $username . $birthday->format('m/d/y');

                        // Calculate age
                        $today = new \DateTime();
                        $age = $birthday->diff($today)->y;

                        // Create user with generated credentials and calculated age
                        $user = User::create([
                            'student_id' => $userData['id'],
                            'first_name' => $userData['first_name'],
                            'middle_name' => $userData['middle_name'],
                            'last_name' => $userData['last_name'],
                            'email' => $userData['email'],
                            'password' => $password,
                            'degree_name' => $userData['degree_name'],
                            'age' => $age,
                            'role' => 'user' // Default role
                        ]);

                        $insertedCount++;
                        $generatedCredentials[] = [
                            'id' => $userData['id'],
                            'name' => $userData['first_name'] . ' ' . $userData['last_name'],
                            'username' => $username,
                            'password' => $password
                        ];

                        // Log progress every 50 records
                        if ($insertedCount % 50 === 0) {
                            \Log::info('User CSV upload progress', ['inserted' => $insertedCount]);
                        }

                    } catch (\Exception $e) {
                        $errors[] = "Row " . ($rowIndex + 2) . ": " . $e->getMessage();
                        $errorCount++;
                        \Log::error('Error processing user row', [
                            'rowIndex' => $rowIndex + 2,
                            'error' => $e->getMessage()
                        ]);
                    }
                }

                // Commit transaction
                DB::commit();

                // Clean up temporary files
                if (File::exists($tempDir)) {
                    File::deleteDirectory($tempDir);
                }

                \Log::info('User CSV upload completed', [
                    'inserted' => $insertedCount,
                    'errors' => $errorCount,
                    'totalRows' => count($csvData)
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => "Users uploaded successfully. {$insertedCount} users created, {$errorCount} errors.",
                    'data' => [
                        'insertedCount' => $insertedCount,
                        'errorCount' => $errorCount,
                        'totalRows' => count($csvData),
                        'errors' => $errors,
                        'generatedCredentials' => $generatedCredentials
                    ]
                ]);

            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

        } catch (\Exception $e) {
            \Log::error('User CSV upload error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Clean up temporary files
            if (isset($tempDir) && File::exists($tempDir)) {
                File::deleteDirectory($tempDir);
            }
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to upload users: ' . $e->getMessage()
            ], 400);
        }
    }
}
