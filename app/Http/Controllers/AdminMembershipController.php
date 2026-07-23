<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\User;
use Illuminate\Http\Request;

class AdminMembershipController extends Controller
{
    public function index()
    {
        $memberships = Membership::orderBy('id_member', 'desc')->get();

        $totalMember   = $memberships->count();
        $memberSilver  = $memberships->where('tingkat', 'Silver')->count();
        $memberGold    = $memberships->where('tingkat', 'Gold')->count();
        $memberPlatinum = $memberships->where('tingkat', 'Platinum')->count();
        $memberAktif   = $memberships->where('status', 'aktif')->count();

        $diskonSilver  = $memberships->where('tingkat', 'Silver')->first()?->diskon ?? 0;
        $diskonGold    = $memberships->where('tingkat', 'Gold')->first()?->diskon ?? 0;
        $diskonPlatinum = $memberships->where('tingkat', 'Platinum')->first()?->diskon ?? 0;

        return view('admin.membership.index', compact(
            'memberships', 'totalMember', 'memberSilver', 'memberGold', 'memberPlatinum', 'memberAktif',
            'diskonSilver', 'diskonGold', 'diskonPlatinum'
        ));
    }

    public function create()
    {
        $pelanggan = User::where('role', 'pelanggan')->get();
        return view('admin.membership.create', compact('pelanggan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nm_member'   => 'required|string|max:100',
            'tingkat'     => 'required|in:Silver,Gold,Platinum',
            'diskon'      => 'required|numeric|min:0',
            'masa_berlaku' => 'required|integer|min:0',
            'status'      => 'required|in:aktif,non_aktif,suspend',
        ]);

        Membership::create($request->only(['nm_member', 'tingkat', 'diskon', 'masa_berlaku', 'status']));

        buatNotif(auth()->id(), 'Membership Ditambahkan', 'Membership ' . $request->nm_member . ' (' . $request->tingkat . ') berhasil ditambahkan', 'Lainnya', route('admin.membership.index'));

        return redirect()->route('admin.membership.index')
            ->with('success', 'Membership berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $membership = Membership::findOrFail($id);
        $pelanggan = User::where('role', 'pelanggan')->get();
        return view('admin.membership.edit', compact('membership', 'pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nm_member'   => 'required|string|max:100',
            'tingkat'     => 'required|in:Silver,Gold,Platinum',
            'diskon'      => 'required|numeric|min:0',
            'masa_berlaku' => 'required|integer|min:0',
            'status'      => 'required|in:aktif,non_aktif,suspend',
        ]);

        $membership = Membership::findOrFail($id);
        $membership->update($request->only(['nm_member', 'tingkat', 'diskon', 'masa_berlaku', 'status']));

        buatNotif(auth()->id(), 'Membership Diperbarui', 'Membership ' . $membership->nm_member . ' berhasil diperbarui', 'Lainnya', route('admin.membership.edit', $membership->id_member));

        return redirect()->route('admin.membership.index')
            ->with('success', 'Membership berhasil diperbarui.');
    }
    
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:aktif,suspend,non_aktif',
        ]);

        Membership::where('id_member', $id)->update([
            'status' => $request->status,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }

    public function destroy($id)
    {
        $membership = Membership::findOrFail($id);
        $nm = $membership->nm_member;
        $membership->delete();

        buatNotif(auth()->id(), 'Membership Dihapus', 'Membership ' . $nm . ' berhasil dihapus dari sistem', 'Lainnya', route('admin.membership.index'));

        return redirect()->route('admin.membership.index')
            ->with('success', 'Membership berhasil dihapus.');
    }
}
