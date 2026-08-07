<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminPelangganController extends Controller
{
    public function index(Request $request)
    {
        $sortOrder = $request->filter_sort === 'asc' ? 'asc' : 'desc';

        $onlineQuery = User::where('role', 'pelanggan')
            ->leftJoin('pelanggan', 'users.id', '=', 'pelanggan.id_user')
            ->select(
                'users.id as user_id',
                'users.nama',
                'users.email',
                'users.no_hp',
                'users.foto',
                'users.status',
                'users.suspend_until',
                'users.created_at',
                'pelanggan.id_pelanggan',
                'pelanggan.nm_pelanggan',
                'pelanggan.alamat',
                'pelanggan.id_member',
                'pelanggan.tgl_mulai_member',
                'pelanggan.catatan_alergi',
            );

        $walkinQuery = Pelanggan::whereNull('id_user')
            ->whereRaw('email NOT IN (SELECT email FROM users WHERE role = ? AND email IS NOT NULL)', ['pelanggan'])
            ->select(
                DB::raw('NULL as user_id'),
                DB::raw('NULL as nama'),
                'email',
                'no_hp',
                'foto',
                DB::raw('NULL as status'),
                'created_at',
                'id_pelanggan',
                'nm_pelanggan',
                'alamat',
                'id_member',
                'tgl_mulai_member',
                'catatan_alergi',
            );

        if ($request->filled('search')) {
            $search = $request->search;
            $onlineQuery->where(function ($q) use ($search) {
                $q->where('users.nama', 'like', "%{$search}%")
                  ->orWhere('users.email', 'like', "%{$search}%")
                  ->orWhere('users.no_hp', 'like', "%{$search}%")
                  ->orWhere('pelanggan.alamat', 'like', "%{$search}%")
                  ->orWhere('pelanggan.nm_pelanggan', 'like', "%{$search}%");
            });
            $walkinQuery->where(function ($q) use ($search) {
                $q->where('nm_pelanggan', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        if ($request->filled('filter_member')) {
            if ($request->filter_member === 'yes') {
                $onlineQuery->whereNotNull('pelanggan.id_member');
                $walkinQuery->whereNotNull('id_member');
            } elseif ($request->filter_member === 'no') {
                $onlineQuery->whereNull('pelanggan.id_member');
                $walkinQuery->whereNull('id_member');
            }
        }

        $online = $onlineQuery->get()->each(fn($item) => $item->sumber = 'Online');
        $walkin = $walkinQuery->get()->each(fn($item) => $item->sumber = 'Walk-in');

        $filterSumber = $request->filter_sumber;
        if ($filterSumber === 'online') {
            $pelanggan = $online;
        } elseif ($filterSumber === 'walkin') {
            $pelanggan = $walkin;
        } else {
            $pelanggan = $online->concat($walkin);
        }

        $pelanggan = $sortOrder === 'asc'
            ? $pelanggan->sortBy('created_at')
            : $pelanggan->sortByDesc('created_at');
        $pelanggan = $pelanggan->values();

        if ($request->ajax()) {
            $memberships = \App\Models\Membership::all()->keyBy('id_member');

            return view('admin.pelanggan.partials.table', compact('pelanggan', 'memberships'));
        }

        $memberships = \App\Models\Membership::all()->keyBy('id_member');

        return view('admin.pelanggan.index', compact('pelanggan', 'memberships'));
    }

    public function create()
    {
        return view('admin.pelanggan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nm_pelanggan'  => 'required|string|max:100',
            'no_hp'         => 'nullable|string|max:20',
            'email'         => 'required|email|max:100',
            'alamat'        => 'required|string',
            'catatan_alergi'=> 'required|string',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nm_pelanggan', 'no_hp', 'email', 'alamat', 'catatan_alergi']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('pelanggan', 'public');
        }

        Pelanggan::create($data);

        buatNotif(auth()->id(), 'Pelanggan Ditambahkan', 'Pelanggan ' . $request->nm_pelanggan . ' berhasil ditambahkan', 'Lainnya', route('admin.pelanggan.index'));

        return redirect()->route('admin.pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit(Pelanggan $pelanggan)
    {
        if (!is_null($pelanggan->id_user)) {
            return redirect()->route('admin.pelanggan.index')
                ->with('error', 'Pelanggan dari akun online tidak dapat diedit.');
        }
        $memberships = \App\Models\Membership::where('status', 'aktif')
            ->orderBy('nm_member')
            ->get();
        return view('admin.pelanggan.edit', compact('pelanggan', 'memberships'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        if (!is_null($pelanggan->id_user)) {
            return redirect()->route('admin.pelanggan.index')
                ->with('error', 'Pelanggan dari akun online tidak dapat diedit.');
        }

        $rules = [
            'nm_pelanggan'  => 'required|string|max:100',
            'no_hp'         => 'nullable|string|max:20',
            'email'         => 'required|email|max:100',
            'alamat'        => 'required|string',
            'catatan_alergi'=> 'required|string',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        $isWalkin = is_null($pelanggan->id_user);

        if ($isWalkin) {
            if ($request->boolean('konversi_online')) {
                $rules['password'] = 'required|string|confirmed';
                $rules['email'] = 'required|email|max:100|unique:users,email';
            }
        } else {
            $rules['id_member'] = 'nullable|integer';
        }

        $request->validate($rules);

        $data = $request->only(['nm_pelanggan', 'no_hp', 'email', 'alamat', 'catatan_alergi']);

        if (!$isWalkin) {
            $data['id_member'] = $request->id_member;

            if ($request->id_member) {
                if ($pelanggan->id_member != $request->id_member || !$pelanggan->tgl_mulai_member) {
                    $data['tgl_mulai_member'] = now()->toDateString();
                }
            } else {
                $data['tgl_mulai_member'] = null;
            }
        }

        if ($request->hasFile('foto')) {
            if ($pelanggan->foto) {
                Storage::disk('public')->delete($pelanggan->foto);
            }
            $data['foto'] = $request->file('foto')->store('pelanggan', 'public');
        }

        if ($isWalkin && $request->boolean('konversi_online')) {
            $user = User::create([
                'nama'     => $request->nm_pelanggan,
                'email'    => $request->email,
                'no_hp'    => $request->no_hp,
                'password' => Hash::make($request->password),
                'role'     => 'pelanggan',
                'status'   => 'aktif',
            ]);
            $data['id_user'] = $user->id;
        }

        $pelanggan->update($data);

        if ($pelanggan->id_user) {
            $userData = [
                'nama'  => $request->nm_pelanggan,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
            ];
            if (!empty($data['foto'])) {
                $userData['foto'] = $data['foto'];
            }
            if (array_key_exists('alamat', $data)) {
                $userData['alamat'] = $data['alamat'];
            }
            $pelanggan->user()->update($userData);
        }

        buatNotif(auth()->id(), 'Pelanggan Diperbarui', 'Data pelanggan ' . $pelanggan->nm_pelanggan . ' berhasil diperbarui', 'Lainnya', route('admin.pelanggan.edit', $pelanggan->id_pelanggan));

        return redirect()->route('admin.pelanggan.index')
            ->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        if (!is_null($pelanggan->id_user)) {
            return redirect()->route('admin.pelanggan.index')
                ->with('error', 'Pelanggan dari akun online tidak dapat dihapus.');
        }

        if ($pelanggan->foto) {
            Storage::disk('public')->delete($pelanggan->foto);
        }

        $nm = $pelanggan->nm_pelanggan;
        $userId = $pelanggan->id_user;
        $pelanggan->delete();

        if ($userId) {
            User::where('id', $userId)->delete();
        }

        buatNotif(auth()->id(), 'Pelanggan Dihapus', 'Pelanggan ' . $nm . ' berhasil dihapus dari sistem', 'Lainnya', route('admin.pelanggan.index'));

        return redirect()->route('admin.pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus.');
    }

    public function toggleStatus(User $user)
    {
        if (in_array($user->status, ['suspend', 'non_aktif', 'menunggu_persetujuan'])) {
            $user->status = 'aktif';
            $user->suspend_until = null;
        } else {
            $user->status = 'non_aktif';
            $user->suspend_until = null;
        }
        $user->save();

        $aksi = $user->status === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';
        buatNotif($user->id, 'Status Akun', 'Akun Anda telah ' . $aksi . ' oleh ' . auth()->user()->nama, 'Lainnya', route('admin.pelanggan.index'));

        return redirect()->route('admin.pelanggan.index')
            ->with('success', 'Status pelanggan berhasil ' . $aksi . '.');
    }
}
