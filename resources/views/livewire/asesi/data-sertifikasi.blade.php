<x-filament::section>
    <x-slot name="heading">
        Bagian 2 : Data Sertifikasi
    </x-slot>

    <x-slot name="description">
        Tuliskan Judul dan Nomor Skema Sertifikasi yang anda akan ajukan berikut Daftar Unit Kompetensi sesuai kemasan pada skema sertifikasi untuk mendapatkan pengakuan sesuai dengan latar belakang pendidikan, pelatihan serta pengalaman kerja yang anda miliki.
    </x-slot>

    <form wire:submit="save">

        {{ $this->form }}

        <p class="py-2">Tanda tangan</p>

        <div style="max-width: 300px" wire:ignore>
            <div x-data="{
                signaturePadId: $id('signature'),
                signaturePad: null,
                signature: @entangle('signature').live,
                ratio: null,
                init() {
                    this.resizeCanvas(); // resize canvas before initializing
                    this.signaturePad = new SignaturePad(this.$refs.canvas);
                    if (this.signature) {
                        // pass ratio when loading a saved signature
                        this.signaturePad.fromDataURL(this.signature, { ratio: this.ratio });
                    }
                },
                save() {
                    this.signature = this.signaturePad.toDataURL();
                    this.$dispatch('signature-saved', this.signaturePadId);
                },
                clear() {
                    this.signaturePad.clear();
                    this.signature = null;
                },
                // The resize canvas function https://github.com/szimek/signature_pad#tips-and-tricks﻿
                resizeCanvas() {
                    this.ratio = Math.max(window.devicePixelRatio || 1, 1);
                    this.$refs.canvas.width = this.$refs.canvas.offsetWidth * this.ratio;
                    this.$refs.canvas.height = this.$refs.canvas.offsetHeight * this.ratio;
                    this.$refs.canvas.getContext('2d').scale(this.ratio, this.ratio);
                }
            }" @resize.window="resizeCanvas">

                <canvas x-ref="canvas" class="w-full h-full border-2 border-gray-300 border-dashed rounded-md "></canvas>

                <div class="flex mt-2 space-x-2">
                    <x-filament::button size="xs" color="danger" x-on:click.prevent="clear()" >
                        Bersihkan
                    </x-filament::button>

                    <x-filament::button size="xs" color="success" x-on:click.prevent="save()">
                        Simpan
                    </x-filament::button>

                    <span x-data="{
                        open: false,
                        saved(e) {
                            if (e.detail != this.signaturePadId) {
                                return;
                            }
                            this.open = true;
                            setTimeout(() => { this.open = false }, 900);
                        }
                    }" x-show="open" @signature-saved.window="saved" x-transition
                        class="text-sm font-medium text-green-700 " style="display:none">
                        Saved !
                    </span>

                </div>

            </div>
        </div>

        <x-filament::button type="submit" class="mt-2">
            Submit
        </x-filament::button>
    </form>

    <x-filament-actions::modals />

</x-filament::section>
