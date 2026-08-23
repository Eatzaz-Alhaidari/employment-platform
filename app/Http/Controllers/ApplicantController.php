<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicantController extends Controller
{
    /**
     * Show the employment application form.
     */
    public function create()
    {
        return view('applicants.create');
    }

    /**
     * Store a newly created employment application.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'   => ['required', 'string', 'max:150'],
            'national_id' => ['required', 'digits:10', 'unique:applicants,national_id'],
            'gender'      => ['required', 'in:ذكر,أنثى'],
            'birth_date'  => ['required', 'date', 'before:today'],
            'nationality' => ['required', 'string', 'max:100'],
            'cv_path'     => ['required', 'file', 'mimes:pdf', 'max:5120'],
            'id_path'     => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ], [
            'full_name.required'   => 'يرجى إدخال الاسم الكامل.',
            'full_name.max'        => 'الاسم الكامل يجب ألا يتجاوز 150 حرفاً.',
            'national_id.required' => 'يرجى إدخال رقم الهوية الوطنية / الإقامة.',
            'national_id.digits'   => 'رقم الهوية يجب أن يتكون من 10 أرقام تماماً.',
            'national_id.unique'   => 'رقم الهوية هذا مسجل مسبقاً في النظام.',
            'gender.required'      => 'يرجى تحديد الجنس.',
            'gender.in'            => 'الجنس المحدد غير صالح.',
            'birth_date.required'  => 'يرجى تحديد تاريخ الميلاد.',
            'birth_date.date'      => 'صيغة تاريخ الميلاد غير صحيحة.',
            'birth_date.before'    => 'تاريخ الميلاد يجب أن يكون تاريخاً سابقاً لتاريخ اليوم.',
            'nationality.required' => 'يرجى إدخال الجنسية.',
            'cv_path.required'     => 'يرجى رفع ملف السيرة الذاتية.',
            'cv_path.mimes'        => 'يجب أن يكون ملف السيرة الذاتية بصيغة PDF فقط.',
            'cv_path.max'          => 'حجم ملف السيرة الذاتية يجب ألا يتجاوز 5 ميجابايت.',
            'id_path.required'     => 'يرجى رفع مستند الهوية.',
            'id_path.mimes'        => 'يجب أن يكون مستند الهوية بصيغة PDF أو صورة (JPG, PNG).',
            'id_path.max'          => 'حجم مستند الهوية يجب ألا يتجاوز 5 ميجابايت.',
        ]);

        // Securely store the uploaded files into the public disk
        $cvPath = $request->file('cv_path')->store('applicants/cvs', 'public');
        $idPath = $request->file('id_path')->store('applicants/ids', 'public');

        $applicant = Applicant::create([
            'full_name'   => $validated['full_name'],
            'national_id' => $validated['national_id'],
            'gender'      => $validated['gender'],
            'birth_date'  => $validated['birth_date'],
            'nationality' => $validated['nationality'],
            'cv_path'     => $cvPath,
            'id_path'     => $idPath,
            'status'      => 'جديد',
        ]);

        return redirect()->route('applicant.success', $applicant->id)
            ->with('success', 'تم تقديم طلب التوظيف بنجاح! شكراً لاهتمامك بالانضمام إلينا.');
    }

    /**
     * Display application submission confirmation page.
     */
    public function success(Applicant $applicant)
    {
        return view('applicants.success', compact('applicant'));
    }
}
