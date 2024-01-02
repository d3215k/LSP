 <x-print-layout>
    <x-slot name="title">
        {{ $sertifikat->no_sertifikat . ' ' . $sertifikat->pemilik }}
    </x-slot>

    <div class="relative flex flex-col mx-auto overflow-hidden bg-white xl:max-w-4xl ">
        <div class="w-full p-5 lg:p-6 grow print:p-0">
            <div class="mx-auto text-center lg:w-10/12 print:w-full">
                <div class="space-y-6 leading-5">
                    <div class="flex justify-center">
                        <img width="120" src="{{ asset('storage/'.$setting->logo) }}" />
                    </div>
                    <div class="mt-6 font-bold uppercase">
                        <h1 class="text-2xl">Sertifikat Kompetensi</h1>
                        <p class="text-lg" class="italic">Certificate Of Competence</p>
                    </div>
                    <div class="font-bold">
                        NO. {{ $sertifikat->no_sertifikat }}
                    </div>

                    <div>
                        <p>Dengan ini menyatakan bahwa</p>
                        <p class="italic">This is to certify that,</p>
                    </div>

                    <div class="text-xl font-bold">
                        <p>{{ $sertifikat->pemilik }}</p>
                    </div>

                    <div>
                        <p>Telah kompeten pada bidang:</p>
                        <p class="italic">Has been competence in the area of:</p>
                    </div>

                    <div class="font-bold">
                        <p>{{ $sertifikat->bidang }}</p>
                        <p class="italic">Freshwater Fish Cultivation</p>
                    </div>

                    <div>
                        <p>Dengan Kualifikasi/Kompetensi:</p>
                        <p class="italic">With Qualifications/Competency:</p>
                    </div>

                    <div class="font-bold">
                        <p>KKNI Level II pada Kompetensi Keahlian</p>
                        <p class="italic">KKNI Level II on Skills Competence of</p>
                    </div>

                    <div class="text-xl font-bold">
                        <p>AGRIBISNIS PERIKANAN AIR TAWAR</p>
                        <p class="italic">FRESHWATER FISHERIES AGRIBUSINESS</p>
                    </div>

                    <div>
                        <p>Sertifikat ini berlaku untuk : {{ $setting->masa_berlaku }}</p>
                        <p class="italic">This certificate is valid for : {{ $setting->masa_berlaku_en }}</p>
                    </div>

                    <div>
                        <p>{{ $setting->tempat_terbit }}, {{ $sertifikat->tanggal_terbit }}</p>
                    </div>

                    <div>
                        <p>{{ $setting->nama_lembaga }}</p>
                        <p class="italic">{{ $setting->nama_lembaga_en }}</p>
                    </div>

                    <div class="pt-12 font-bold ">
                        <p>{{ $setting->ketua_lsp }}</p>
                        <p>Ketua</p>
                        <p class="italic">Chairman</p>
                    </div>
                </div>

                <div class="pagebreak"> </div>

                <div class="mr-12 text-sm">
                    <div class="text-xl font-bold">
                        <h1>Daftar Unit Kompetensi</h1>
                        <p class="italic text-md">List of Competency Units</p>
                    </div>

                    <div class="mt-12">
                        <table class="w-full border border-collapse border-gray-600">
                            <tr class="bg-gray-100">
                                <th class="border border-gray-600">No</th>
                                <th class="border border-gray-600">
                                    <p>Kode Unit Kompetensi</p>
                                    <p class="italic">Code of Competency Unit</p>
                                </th>
                                <th class="border border-gray-600">
                                    <p>Judul Unit Kompetensi</p>
                                    <p class="italic">Title of Competency Unit</p>
                                </th>
                            </tr>
                            @foreach (json_decode($sertifikat->unit) as $unit)
                            <tr>
                                <td class="border border-gray-600">{{ $loop->iteration }}</td>
                                <td class="border border-gray-600">{{ $unit->kode }}</td>
                                <td class="border border-gray-600">
                                    <p>{{ $unit->judul }}</p>
                                    <p class="italic">{{ $unit->judul_en }}</p>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>

                    <div class="w-full mt-24 text-right">
                        <p>Cibadak, 5 Mei 2023</p>
                        <p>{{ $setting->nama_lembaga }}</p>
                        <p class="italic">{{ $setting->nama_lembaga_en }}</p>
                    </div>

                    <div class="flex mt-32">
                        <div class="relative w-40 ml-12">
                            <div class="absolute px-6 py-12 border border-gray-200 -top-32">
                                <p>Pas Photo</p>
                                <p>3x4</p>
                            </div>
                        </div>
                        <div class="text-left">
                            <p class="font-bold">{{ $sertifikat->pemilik }}</p>
                            <p>Tanda Tangan Pemilik</p>
                            <p class="italic">Signature of holder</p>
                        </div>
                        <div class="flex-1 text-right">
                            <p class="font-bold">{{ $setting->ketua_bidang_sertifikasi }}</p>
                            <p>Ketua Bidang Sertifikasi</p>
                            <p class="italic">Head of Certification</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-print-layout>
