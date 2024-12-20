<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function calon_mahasiswa()
    {
        return $this->hasOne(Calon_mahasiswa::class);
    }

    public function assessor()
    {
        return $this->hasOne(Assessor::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }
    public function super_admin()
    {
        return $this->hasOne(Super_admin::class);
    }
    
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    public function getRoleName() {
    if ($this->role === 'pendaftar') {
        return $this->Calon_mahasiswa ? $this->Calon_mahasiswa->nama : 'Nama Tidak Tersedia';
    } elseif ($this->role === 'assessor') {
        return $this->Assessor ? $this->Assessor->nama : 'Nama Tidak Tersedia';
    } elseif ($this->role === 'admin') {
        return $this->Admin ? $this->Admin->nama : 'Nama Tidak Tersedia';
    }
    return 'Nama Tidak Tersedia';
    }
    
    public function getProfileInfo(){
    $defaultImage = 'public/Data/profile_pict/gambar_default.jpg';
    $namaJurusan = 'Jurusan Tidak Tersedia'; // Default value if jurusan is not found

    if ($this->role === 'assessor') {
        $fotoPath = $this->assessor && $this->assessor->foto ? 'public/Data/profile_pict_assesor/' . $this->assessor->foto : $defaultImage;
        $namaJurusan = $this->assessor && $this->assessor->jurusan ? $this->assessor->jurusan->nama_jurusan : 'Jurusan Tidak Tersedia';
    } elseif ($this->role === 'admin') {
        $fotoPath = $this->admin && $this->admin->foto ? 'public/Data/profile_pict_admin/' . $this->admin->foto : $defaultImage;
        $namaJurusan = $this->admin && $this->admin->jurusan ? $this->admin->jurusan->nama_jurusan : 'Jurusan Tidak Tersedia';
    } elseif ($this->role === 'pendaftar') {
        $fotoPath = $this->calon_mahasiswa && $this->calon_mahasiswa->foto ? 'public/Data/profile_pict_camaba/' . $this->calon_mahasiswa->foto : $defaultImage;
        $namaJurusan = $this->calon_mahasiswa && $this->calon_mahasiswa->jurusan ? $this->calon_mahasiswa->jurusan->nama_jurusan : 'Jurusan Tidak Tersedia';
    } else {
        $fotoPath = $defaultImage;
    }

    return [
        'nama' => $this->getRoleName(),
        'foto_url' => asset($fotoPath),
        'jurusan' => $namaJurusan // Add jurusan to the profile info
    ];
    }

}
