<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\AboutpageController;
use App\Http\Controllers\CampusLifeController;
use App\Http\Controllers\CCSDepartmentController;
use App\Http\Controllers\AcademicsController;
use App\Http\Controllers\ContactpageController;
use App\Http\Controllers\EventpageController;
use App\Http\Controllers\NewsArticleController;
use App\Http\Controllers\NewspageController;
use App\Http\Controllers\ResearchpageController;
use App\Http\Controllers\Admin\ModelUploadController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CompanyController as AdminCompanyController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\ForecastingController;
use App\Http\Controllers\Admin\EmploymentComparisonController;
use App\Http\Controllers\Admin\StudentForecastController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\FeedbackManagementController;
use Illuminate\Support\Facades\Mail;


// Home route
Route::get('/alumni', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutpageController::class, 'index'])->name('aboutpage');
Route::get('/campuslife', [CampusLifeController::class, 'index'])->name('campus_life');
Route::get('/ccsdepartment', [CCSDepartmentController::class, 'index'])->name('ccs_academic');
Route::get('/academics', [AcademicsController::class, 'index'])->name('academics');
Route::get('/contact', [ContactpageController::class, 'index'])->name('contactpage');
Route::get('/events', [EventpageController::class, 'index'])->name('eventspage');
Route::get('/news-article', [NewsArticleController::class, 'index'])->name('news_article');
Route::get('/news', [NewspageController::class, 'index'])->name('newspage');
Route::get('/research', [ResearchpageController::class, 'index'])->name('researchpage');
Route::get('/', [HomepageController::class, 'index'])->name('homepage');

Route::middleware(['auth'])->group(function () {


    // Jobs routes
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');
    Route::post('/jobs/{job}/save', [JobController::class, 'saveJob'])->name('jobs.save');
    Route::delete('/jobs/{job}/unsave', [JobController::class, 'unsaveJob'])->name('jobs.unsave');
    Route::get('/saved-jobs', [JobController::class, 'savedJobs'])->name('saved-jobs.index');

    // Companies routes
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('/companies/{company}', [CompanyController::class, 'show'])->name('companies.show');

    // Feedback routes
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications', [NotificationController::class, 'destroyAll'])->name('notifications.destroyAll');

    Route::get('/alumnidashboard', [DashboardController::class, 'index'])->name('alumnidashboard');
});



Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Protect the dashboard and model upload routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('/admindashboard', [AdminDashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/model-upload', [ModelUploadController::class, 'index'])->name('model-upload.index');
        Route::post('/model-upload', [ModelUploadController::class, 'store'])->name('model-upload.store');

        // Companies Routes
        Route::get('/companies', [AdminCompanyController::class, 'index'])->name('companies.index');
        Route::post('/companies', [AdminCompanyController::class, 'store'])->name('companies.store');
        Route::get('/companies/{company}/edit', [AdminCompanyController::class, 'edit'])->name('companies.edit');
        Route::put('/companies/{company}', [AdminCompanyController::class, 'update'])->name('companies.update');
        Route::delete('/companies/{company}', [AdminCompanyController::class, 'destroy'])->name('companies.destroy');

        // Jobs Routes
        Route::get('/jobs', [AdminJobController::class, 'index'])->name('jobs.index');
        Route::post('/jobs', [AdminJobController::class, 'store'])->name('jobs.store');
        Route::get('/jobs/{job}/edit', [AdminJobController::class, 'edit'])->name('jobs.edit');
        Route::put('/jobs/{job}', [AdminJobController::class, 'update'])->name('jobs.update');
        Route::delete('/jobs/{job}', [AdminJobController::class, 'destroy'])->name('jobs.destroy');

        Route::get('/forecasting', [ForecastingController::class, 'index'])->name('forecasting.index');

        Route::get('/employment-comparison', [EmploymentComparisonController::class, 'index'])->name('employment-comparison.index');
        
        Route::get('/student-forecast', [StudentForecastController::class, 'index'])->name('student-forecast.index');
        Route::post('/student-forecast', [StudentForecastController::class, 'processPrediction'])->name('student-forecast.processPrediction');

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/print', [ReportController::class, 'printReport'])->name('reports.print');

        // Inside the middleware('auth:admin') group
        Route::get('/feedbacks', [FeedbackManagementController::class, 'index'])->name('feedbacks.index');
        Route::delete('/feedbacks/{feedback}', [FeedbackManagementController::class, 'destroy'])->name('feedbacks.destroy');
        Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
        Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
        Route::get('/users/{user}/view', [UserManagementController::class, 'show'])->name('users.show');
    }); 

    
});

Route::get('/test-mail', function () {
    try {
        Mail::raw('Test email', function ($message) {
            $message->to('your-email@example.com')
                   ->subject('Test Subject');
        });
        return 'Email sent successfully!';
    } catch (\Exception $e) {
        return 'Email error: ' . $e->getMessage();
    }
});

require __DIR__.'/auth.php';

