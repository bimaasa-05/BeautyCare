<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;

class AdminMembershipController extends Controller
{
    public function index()
    {
        $memberships = Membership::orderBy('min_transaksi')->orderBy('min_pembelian')->get();

        $totalMember = $memberships->count();
        $semuaTingkat = $memberships->groupBy('tingkat');
        $memberAktif = $memberships->where('status', 'aktif')->count();

        $statPerTingkat = [];
        foreach ($semuaTingkat as $tingkat => $items) {
            $statPerTingkat[$tingkat] = [
                'total' => $items->count(),
                'diskon' => $items->first()?->diskon ?? 0,
            ];
        }

        return view('admin.membership.index', compact(
            'memberships', 'totalMember', 'memberAktif', 'statPerTingkat'
        ));
    }

    public function create()
    {
        $semuaTingkat = Membership::distinct()->pluck('tingkat');
        return view('admin.membership.create', compact('semuaTingkat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nm_member'    => 'required|string|max:100',
            'tingkat'      => 'required|string|max:50',
            'diskon'       => 'required|numeric|min:0|max:100',
            'min_transaksi' => 'required|integer|min:0',
            'min_pembelian' => 'required|numeric|min:0',
            'masa_berlaku' => 'required|integer|min:0',
            'deskripsi'    => 'nullable|string|max:500',
        ]);

        Membership::create([
            'nm_member'    => $request->nm_member,
            'tingkat'      => $request->tingkat,
            'diskon'       => $request->diskon,
            'min_transaksi' => $request->min_transaksi,
            'min_pembelian' => $request->min_pembelian,
            'masa_berlaku' => $request->masa_berlaku,
            'deskripsi'    => $request->deskripsi,
            'status'       => $request->masa_berlaku > 0 ? 'aktif' : 'non_aktif',
        ]);

        buatNotif(auth()->id(), 'Membership Ditambahkan', 'Paket membership ' . $request->nm_member . ' (' . $request->tingkat . ') berhasil ditambahkan', 'Lainnya', route('admin.membership.index'));

        return redirect()->route('admin.membership.index')
            ->with('success', 'Paket membership berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $membership = Membership::findOrFail($id);
        $semuaTingkat = Membership::distinct()->pluck('tingkat');
        return view('admin.membership.edit', compact('membership', 'semuaTingkat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nm_member'    => 'required|string|max:100',
            'tingkat'      => 'required|string|max:50',
            'diskon'       => 'required|numeric|min:0|max:100',
            'min_transaksi' => 'required|integer|min:0',
            'min_pembelian' => 'required|numeric|min:0',
            'masa_berlaku' => 'required|integer|min:0',
            'deskripsi'    => 'nullable|string|max:500',
        ]);

        $membership = Membership::findOrFail($id);

        $membership->update([
            'nm_member'    => $request->nm_member,
            'tingkat'      => $request->tingkat,
            'diskon'       => $request->diskon,
            'min_transaksi' => $request->min_transaksi,
            'min_pembelian' => $request->min_pembelian,
            'masa_berlaku' => $request->masa_berlaku,
            'deskripsi'    => $request->deskripsi,
            'status'       => $request->masa_berlaku > 0 ? 'aktif' : 'non_aktif',
        ]);

        buatNotif(auth()->id(), 'Membership Diperbarui', 'Paket membership ' . $membership->nm_member . ' berhasil diperbarui', 'Lainnya', route('admin.membership.edit', $membership->id_member));

        return redirect()->route('admin.membership.index')
            ->with('success', 'Paket membership berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $membership = Membership::findOrFail($id);
        $nm = $membership->nm_member;
        $membership->delete();

        buatNotif(auth()->id(), 'Membership Dihapus', 'Paket membership ' . $nm . ' berhasil dihapus dari sistem', 'Lainnya', route('admin.membership.index'));

        return redirect()->route('admin.membership.index')
            ->with('success', 'Paket membership berhasil dihapus.');
    }

}
