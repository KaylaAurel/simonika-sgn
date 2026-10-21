/* =========================================================
   SIMONIKA SGN
   LOGIN JAVASCRIPT
   ========================================================= */

document.addEventListener(
    "DOMContentLoaded",
    () => {
        initializePasswordToggle();
        initializeLoginForm();
    }
);

/* =========================================================
   PASSWORD TOGGLE
   ========================================================= */

function initializePasswordToggle() {
    const buttons =
        document.querySelectorAll(
            "[data-password-toggle]"
        );

    buttons.forEach((button) => {
        button.addEventListener(
            "click",
            () => {
                const targetId =
                    button.dataset
                        .passwordToggle;

                const input =
                    document.getElementById(
                        targetId
                    );

                if (!input) {
                    return;
                }

                const isPassword =
                    input.type ===
                    "password";

                input.type =
                    isPassword
                        ? "text"
                        : "password";

                button.setAttribute(
                    "aria-label",
                    isPassword
                        ? "Sembunyikan password"
                        : "Tampilkan password"
                );

                button.textContent =
                    isPassword
                        ? "◉"
                        : "◌";
            }
        );
    });
}

/* =========================================================
   LOGIN FORM
   ========================================================= */

function initializeLoginForm() {
    const form =
        document.querySelector(
            ".login-form"
        );

    if (!form) {
        return;
    }

    form.addEventListener(
        "submit",
        () => {
            const button =
                form.querySelector(
                    ".login-button"
                );

            if (!button) {
                return;
            }

            button.disabled = true;

            const original =
                button.innerHTML;

            button.innerHTML = `
                <span
                    class="spinner"
                ></span>
                Memproses...
            `;

            /*
             * Jika Laravel validation
             * gagal dan halaman tidak
             * berpindah, tombol bisa
             * dikembalikan.
             */

            setTimeout(() => {
                if (
                    document.body
                ) {
                    button.dataset
                        .originalText =
                        original;
                }
            }, 3000);
        }
    );
}