<?php
namespace App\Http\Controllers;

use App\Models\KYC;
use App\Models\Document;
use Illuminate\Http\Request;

class KYCController extends Controller
{
    public function showKYCForm($userId)
    {
        return view('kyc.form', compact('userId'));
    }

    public function submitKYC(Request $request, $userId)
    {
        // Validate the request data
        $request->validate([
            'documents.*' => 'required|image|max:2048',
            'family_member_name' => 'required|string|max:255',
            'family_member_phone' => 'required|string|max:15',
            'relation' => 'required|string|max:255',
            'family_member_id_document' => 'required|image|max:2048',
            'family_member_location_plan' => 'required|image|max:2048',
            'location_plan' => 'required|image|max:2048',
            'id_document' => 'required|image|max:2048',
            'photo' => 'required|image|max:2048',
        ]);

        // Create a new KYC entry
        $kyc = KYC::create([
            'user_id' => $userId,
            'family_member_name' => $request->family_member_name,
            'family_member_phone' => $request->family_member_phone,
            'relation' => $request->relation,
        ]);

        // Save document paths
        $documentPaths = [];
        foreach ($request->file('documents') as $document) {
            $path = $document->store('documents');
            $documentPaths[] = ['kyc_id' => $kyc->id, 'path' => $path];
        }

        // Save family member documents
        $familyDocumentPath = $request->file('family_member_id_document')->store('documents');
        $familyLocationPath = $request->file('family_member_location_plan')->store('documents');
        $locationPlanPath = $request->file('location_plan')->store('documents');
        $idDocumentPath = $request->file('id_document')->store('documents');
        $photoPath = $request->file('photo')->store('documents');

        // Store document paths for the KYC entry
        Document::insert(array_merge($documentPaths, [
            ['kyc_id' => $kyc->id, 'path' => $familyDocumentPath],
            ['kyc_id' => $kyc->id, 'path' => $familyLocationPath],
            ['kyc_id' => $kyc->id, 'path' => $locationPlanPath],
            ['kyc_id' => $kyc->id, 'path' => $idDocumentPath],
            ['kyc_id' => $kyc->id, 'path' => $photoPath],
        ]));

        // Redirect to a success page or back with a success message
        return redirect()->route('home')->with('success', 'KYC submitted successfully!');
    }
}
