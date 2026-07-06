<?php
 
namespace App\Http\Requests;
 
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\KodeBukuFormat;

 
class UpdateBukuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
 
    /**
     * Get the validation rules that apply to the request.
     * Termasuk custom rule KodeBukuFormat dan conditional validation.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $bukuId = $this->route('buku');

        $rules = [
            'kode_buku' => ['required', 'string', 'max:20', 'unique:buku,kode_buku,' . $bukuId, new KodeBukuFormat],
            'judul' => 'required|string|max:200',
            'kategori_id' => 'required|exists:kategori,id',
            'pengarang' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'isbn' => 'nullable|string|max:20',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'bahasa' => 'required|string|max:20',
        ];

        // Jika kategori "Programming", bahasa harus "Inggris"
        $kategori = \App\Models\Kategori::find($this->input('kategori_id'));
        if ($kategori && $kategori->nama_kategori === 'Programming') {
            $rules['bahasa'] = 'required|string|in:Inggris';
        }

        // Jika tahun terbit < 2000, stok maksimal 5
        if ($this->input('tahun_terbit') && (int) $this->input('tahun_terbit') < 2000) {
            $rules['stok'] = 'required|integer|min:0|max:5';
        }

        return $rules;
    }

    /**
     * Pesan error kustom dalam Bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'kode_buku.required' => 'Kode buku wajib diisi.',
            'kode_buku.unique' => 'Kode buku sudah digunakan, silakan gunakan kode lain.',
            'kode_buku.max' => 'Kode buku maksimal 20 karakter.',
            'judul.required' => 'Judul buku wajib diisi.',
            'judul.max' => 'Judul buku maksimal 200 karakter.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'pengarang.required' => 'Nama pengarang wajib diisi.',
            'pengarang.max' => 'Nama pengarang maksimal 100 karakter.',
            'penerbit.required' => 'Nama penerbit wajib diisi.',
            'penerbit.max' => 'Nama penerbit maksimal 100 karakter.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer' => 'Tahun terbit harus berupa angka.',
            'tahun_terbit.min' => 'Tahun terbit tidak boleh kurang dari 1900.',
            'tahun_terbit.max' => 'Tahun terbit tidak boleh melebihi tahun sekarang.',
            'isbn.max' => 'ISBN maksimal 20 karakter.',
            'harga.required' => 'Harga buku wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh bernilai negatif.',
            'stok.required' => 'Stok buku wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka bulat.',
            'stok.min' => 'Stok tidak boleh bernilai negatif.',
            'stok.max' => 'Untuk buku terbitan sebelum tahun 2000, stok maksimal hanya 5.',
            'bahasa.required' => 'Bahasa wajib diisi.',
            'bahasa.in' => 'Untuk kategori Programming, bahasa harus Inggris.',
        ];
    }

}