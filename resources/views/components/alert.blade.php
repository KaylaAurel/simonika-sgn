@if(session('success'))

    <div class="alert alert-success" data-auto-dismiss>

        <div class="alert-icon">
            ✓
        </div>

        <div class="alert-content">

            <strong>
                Berhasil
            </strong>

            <span>
                {{ session('success') }}
            </span>

        </div>

        <button
            type="button"
            class="alert-close"
            data-alert-close
        >
            ×
        </button>

    </div>

@endif


@if(session('error'))

    <div class="alert alert-danger" data-auto-dismiss>

        <div class="alert-icon">
            !
        </div>

        <div class="alert-content">

            <strong>
                Terjadi Kesalahan
            </strong>

            <span>
                {{ session('error') }}
            </span>

        </div>

        <button
            type="button"
            class="alert-close"
            data-alert-close
        >
            ×
        </button>

    </div>

@endif


@if(session('warning'))

    <div class="alert alert-warning" data-auto-dismiss>

        <div class="alert-icon">
            !
        </div>

        <div class="alert-content">

            <strong>
                Perhatian
            </strong>

            <span>
                {{ session('warning') }}
            </span>

        </div>

        <button
            type="button"
            class="alert-close"
            data-alert-close
        >
            ×
        </button>

    </div>

@endif


@if(session('info'))

    <div class="alert alert-info" data-auto-dismiss>

        <div class="alert-icon">
            i
        </div>

        <div class="alert-content">

            <strong>
                Informasi
            </strong>

            <span>
                {{ session('info') }}
            </span>

        </div>

        <button
            type="button"
            class="alert-close"
            data-alert-close
        >
            ×
        </button>

    </div>

@endif


@if($errors->any())

    <div class="alert alert-danger">

        <div class="alert-icon">
            !
        </div>

        <div class="alert-content">

            <strong>
                Periksa kembali data
            </strong>

            <ul>

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

        <button
            type="button"
            class="alert-close"
            data-alert-close
        >
            ×
        </button>

    </div>

@endif