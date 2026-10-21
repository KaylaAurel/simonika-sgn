import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {

    /*
    |--------------------------------------------------------------------------
    | Mobile Public Navbar
    |--------------------------------------------------------------------------
    */

    const publicMenuButton =
        document.getElementById('publicMenuButton');

    const publicMobileMenu =
        document.getElementById('publicMobileMenu');

    if (publicMenuButton && publicMobileMenu) {

        publicMenuButton.addEventListener('click', () => {

            publicMenuButton.classList.toggle('active');

            publicMobileMenu.classList.toggle('active');

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Admin Sidebar
    |--------------------------------------------------------------------------
    */

    const mobileMenuButton =
        document.getElementById('mobileMenuButton');

    const adminSidebar =
        document.getElementById('adminSidebar');

    const sidebarOverlay =
        document.getElementById('sidebarOverlay');

    const sidebarClose =
        document.getElementById('sidebarClose');


    function openSidebar() {

        if (adminSidebar) {
            adminSidebar.classList.add('show');
        }

        if (sidebarOverlay) {
            sidebarOverlay.classList.add('show');
        }

        document.body.classList.add('sidebar-open');

    }


    function closeSidebar() {

        if (adminSidebar) {
            adminSidebar.classList.remove('show');
        }

        if (sidebarOverlay) {
            sidebarOverlay.classList.remove('show');
        }

        document.body.classList.remove('sidebar-open');

    }


    if (mobileMenuButton) {

        mobileMenuButton.addEventListener(
            'click',
            openSidebar
        );

    }


    if (sidebarClose) {

        sidebarClose.addEventListener(
            'click',
            closeSidebar
        );

    }


    if (sidebarOverlay) {

        sidebarOverlay.addEventListener(
            'click',
            closeSidebar
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Alerts
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('[data-alert-close]')
        .forEach(button => {

            button.addEventListener('click', () => {

                const alert =
                    button.closest('.alert');

                if (alert) {

                    alert.classList.add('alert-hiding');

                    setTimeout(() => {

                        alert.remove();

                    }, 250);

                }

            });

        });


    /*
    |--------------------------------------------------------------------------
    | Auto Dismiss Alert
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('[data-auto-dismiss]')
        .forEach(alert => {

            setTimeout(() => {

                if (!alert) {
                    return;
                }

                alert.classList.add('alert-hiding');

                setTimeout(() => {

                    alert.remove();

                }, 250);

            }, 5000);

        });


    /*
    |--------------------------------------------------------------------------
    | Modal
    |--------------------------------------------------------------------------
    */

    function openModal(id) {

        const modal =
            document.getElementById(id);

        if (!modal) {
            return;
        }

        modal.classList.add('show');

        modal.setAttribute(
            'aria-hidden',
            'false'
        );

        document.body.classList.add('modal-open');

    }


    function closeModal(id) {

        const modal =
            document.getElementById(id);

        if (!modal) {
            return;
        }

        modal.classList.remove('show');

        modal.setAttribute(
            'aria-hidden',
            'true'
        );

        document.body.classList.remove('modal-open');

    }


    /*
    |--------------------------------------------------------------------------
    | Open Modal
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('[data-modal-open]')
        .forEach(button => {

            button.addEventListener('click', () => {

                const modalId =
                    button.dataset.modalOpen;

                openModal(modalId);

            });

        });


    /*
    |--------------------------------------------------------------------------
    | Close Modal
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('[data-modal-close]')
        .forEach(button => {

            button.addEventListener('click', () => {

                const modalId =
                    button.dataset.modalClose;

                closeModal(modalId);

            });

        });


    /*
    |--------------------------------------------------------------------------
    | Close Modal by Overlay
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.modal-overlay')
        .forEach(modal => {

            modal.addEventListener(
                'click',
                event => {

                    if (
                        event.target === modal
                    ) {

                        closeModal(modal.id);

                    }

                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | ESC Close
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        event => {

            if (event.key !== 'Escape') {
                return;
            }

            document
                .querySelectorAll('.modal-overlay.show')
                .forEach(modal => {

                    closeModal(modal.id);

                });

            closeSidebar();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Smooth Scroll
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('a[href^="#"]')
        .forEach(anchor => {

            anchor.addEventListener(
                'click',
                function (event) {

                    const targetId =
                        this.getAttribute('href');

                    if (
                        !targetId ||
                        targetId === '#'
                    ) {
                        return;
                    }

                    const target =
                        document.querySelector(targetId);

                    if (!target) {
                        return;
                    }

                    event.preventDefault();

                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });

                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | DOCUMENT EDIT
    | PDF FILE PREVIEW
    |--------------------------------------------------------------------------
    */

    const fileInput =
        document.getElementById('file');

    const uploadBox =
        document.getElementById('documentFileUpload');

    const defaultContent =
        document.getElementById('documentUploadDefault');

    const selectedFile =
        document.getElementById('documentSelectedFile');

    const selectedFileName =
        document.getElementById('selectedFileName');

    const selectedFileSize =
        document.getElementById('selectedFileSize');

    const removeButton =
        document.getElementById('removeSelectedFile');

    const previewBox =
        document.getElementById('documentPdfPreview');

    const previewFrame =
        document.getElementById('documentPdfFrame');


    /*
    |--------------------------------------------------------------------------
    | Jika bukan halaman edit dokumen
    |--------------------------------------------------------------------------
    */

    if (
        !fileInput ||
        !uploadBox ||
        !selectedFile ||
        !previewBox ||
        !previewFrame
    ) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Pilih File PDF
    |--------------------------------------------------------------------------
    */

    fileInput.addEventListener('change', function () {

        const file = this.files[0];

        if (!file) {
            return;
        }


        /*
        |----------------------------------------------------------------------
        | Validasi PDF
        |----------------------------------------------------------------------
        */

        const isPdf =
            file.type === 'application/pdf' ||
            file.name.toLowerCase().endsWith('.pdf');


        if (!isPdf) {

            alert('File harus berformat PDF.');

            this.value = '';

            return;
        }


        /*
        |----------------------------------------------------------------------
        | Validasi ukuran
        |----------------------------------------------------------------------
        */

        const maxSize =
            10 * 1024 * 1024;


        if (file.size > maxSize) {

            alert(
                'Ukuran file maksimal 10 MB.'
            );

            this.value = '';

            return;
        }


        /*
        |----------------------------------------------------------------------
        | Tampilkan nama file
        |----------------------------------------------------------------------
        */

        if (selectedFileName) {

            selectedFileName.textContent =
                file.name;

        }


        /*
        |----------------------------------------------------------------------
        | Tampilkan ukuran file
        |----------------------------------------------------------------------
        */

        if (selectedFileSize) {

            selectedFileSize.textContent =
                formatFileSize(file.size);

        }


        /*
        |----------------------------------------------------------------------
        | Tampilkan area file terpilih
        |----------------------------------------------------------------------
        */

        selectedFile.classList.add('active');

        uploadBox.classList.add('has-file');


        /*
        |----------------------------------------------------------------------
        | Sembunyikan tampilan upload awal
        |----------------------------------------------------------------------
        */

        if (defaultContent) {

            defaultContent.classList.add('hidden');

        }


        /*
        |----------------------------------------------------------------------
        | Buat URL preview PDF
        |----------------------------------------------------------------------
        */

        const fileUrl =
            URL.createObjectURL(file);


        /*
        |----------------------------------------------------------------------
        | Masukkan PDF ke iframe
        |----------------------------------------------------------------------
        */

        previewFrame.src =
            fileUrl;


        /*
        |----------------------------------------------------------------------
        | Tampilkan preview
        |----------------------------------------------------------------------
        */

        previewBox.classList.add('active');

    });


    /*
    |--------------------------------------------------------------------------
    | Hapus File yang Baru Dipilih
    |--------------------------------------------------------------------------
    */

    if (removeButton) {

        removeButton.addEventListener(
            'click',
            function (event) {

                event.preventDefault();

                event.stopPropagation();


                /*
                |--------------------------------------------------------------
                | Kosongkan input
                |--------------------------------------------------------------
                */

                fileInput.value = '';


                /*
                |--------------------------------------------------------------
                | Sembunyikan file terpilih
                |--------------------------------------------------------------
                */

                selectedFile.classList.remove(
                    'active'
                );


                /*
                |--------------------------------------------------------------
                | Kembalikan upload box
                |--------------------------------------------------------------
                */

                uploadBox.classList.remove(
                    'has-file'
                );


                /*
                |--------------------------------------------------------------
                | Tampilkan kembali tampilan awal
                |--------------------------------------------------------------
                */

                if (defaultContent) {

                    defaultContent.classList.remove(
                        'hidden'
                    );

                }


                /*
                |--------------------------------------------------------------
                | Hapus preview
                |--------------------------------------------------------------
                */

                previewBox.classList.remove(
                    'active'
                );

                previewFrame.src = '';

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Format Ukuran File
    |--------------------------------------------------------------------------
    */

    function formatFileSize(bytes) {

        if (bytes === 0) {
            return '0 Bytes';
        }


        const units = [
            'Bytes',
            'KB',
            'MB',
            'GB'
        ];


        const i =
            Math.floor(
                Math.log(bytes) /
                Math.log(1024)
            );


        return (
            parseFloat(
                (
                    bytes /
                    Math.pow(1024, i)
                ).toFixed(2)
            )
            +
            ' ' +
            units[i]
        );

    }

});