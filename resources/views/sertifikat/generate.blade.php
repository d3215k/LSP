 <x-print-layout>
    <x-slot name="title">
        {{ $sertifikat->no_sertifikat . ' ' . $sertifikat->pemilik }}
    </x-slot>

    <div class="relative flex flex-col mx-auto overflow-hidden bg-white xl:max-w-4xl ">
        <div class="w-full p-5 lg:p-6 grow print:p-0">
            <div class="mx-auto text-center lg:w-10/12 print:w-full">
                <div class="space-y-8">
                    <div class="flex justify-center">
                        <img width="150" src="{{ asset('images/logo.png') }}" />
                    </div>
                    <div class="mt-6 text-2xl font-bold uppercase">
                        <h1>Sertifikat Kompetensi</h1>
                        <p class="italic">Certificate Of Competence</p>
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
                        <p>Dengan Kualifikasi/Kompetensi:</p>
                        <p class="italic">With Qualifications/Competency:</p>
                    </div>

                    <div class="font-bold">
                        <p>Skema Sertifikasi KKNI Level III</p>
                        <p class="italic">Certification of Scheme KKNI Level III</p>
                    </div>

                    <div class="font-bold">
                        <p>AGROINDUSTRI</p>
                        <p class="italic">AGROINDUSTRI</p>
                    </div>

                    <div>
                        <p>Sertifikat ini berlaku untuk : 3 (tiga) Tahun</p>
                        <p>This certificate is valid for : 3 (three) Years</p>
                    </div>

                    <div>
                        <p>Cibadak, 5 Mei 2023</p>
                    </div>

                    <div>
                        <p>Lembaga Sertifikasi Profesi SMKN 1 Cibadak</p>
                        <p class="italic">Professional Certification Body of Vocational High School 1 Cibadak</p>
                    </div>

                    <div class="font-bold">
                        <p>Siti Maryam, S.Pt., M.P</p>
                        <p>Ketua</p>
                        <p class="italic">Chairman</p>
                    </div>
                </div>

                <div class="pagebreak"> </div>

                <div class="mr-12">
                    <div class="text-xl font-bold">
                        <h1>Daftar Unit Kompetensi</h1>
                        <p class="italic">List of Competency Units</p>
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
                            <tr>
                                <td class="border border-gray-600">1</td>
                                <td class="border border-gray-600">J.630PROD.001.2</td>
                                <td class="border border-gray-600">Menggunakan Perangkat Komputer</td>
                            </tr>
                        </table>
                    </div>

                    <div class="w-full mt-24 text-right">
                        <p>Cibadak, 5 Mei 2023</p>
                        <p>Lembaga Sertifikasi Profesi SMKN 1 Cibadak</p>
                        <p class="italic">Professional Certification Body of Vocational High School 1 Cibadak</p>
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
                            <p class="font-bold">Wulan Handayani, S.Kom</p>
                            <p>Ketua Bidang Sertifikasi</p>
                            <p class="italic">Head of Certification</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-print-layout>
