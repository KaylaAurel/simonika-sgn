/* =========================================================
   SIMONIKA SGN
   ADMIN JAVASCRIPT
   ========================================================= */

document.addEventListener(
    "DOMContentLoaded",
    () => {
        initializeAdminSidebar();
        initializeAdminSearch();
        initializeAdminDropdown();
    }
);

/* =========================================================
   SIDEBAR
   ========================================================= */

function initializeAdminSidebar() {
    const sidebar =
        document.querySelector(
            ".admin-sidebar"
        );

    const toggle =
        document.querySelector(
            ".admin-mobile-toggle"
        );

    const overlay =
        document.querySelector(
            ".admin-sidebar-overlay"
        );

    if (!sidebar || !toggle) {
        return;
    }

    toggle.addEventListener(
        "click",
        () => {
            sidebar.classList.toggle(
                "open"
            );

            if (overlay) {
                overlay.classList.toggle(
                    "active"
                );
            }
        }
    );

    if (overlay) {
        overlay.addEventListener(
            "click",
            closeSidebar
        );
    }

    sidebar
        .querySelectorAll(
            ".admin-nav-link"
        )
        .forEach((link) => {
            link.addEventListener(
                "click",
                () => {
                    if (
                        window.innerWidth <=
                        1000
                    ) {
                        closeSidebar();
                    }
                }
            );
        });

    function closeSidebar() {
        sidebar.classList.remove(
            "open"
        );

        if (overlay) {
            overlay.classList.remove(
                "active"
            );
        }
    }
}

/* =========================================================
   ADMIN SEARCH
   ========================================================= */

function initializeAdminSearch() {
    const inputs =
        document.querySelectorAll(
            "[data-admin-search]"
        );

    inputs.forEach((input) => {
        input.addEventListener(
            "input",
            () => {
                const targetSelector =
                    input.dataset
                        .adminSearch;

                const keyword =
                    input.value
                        .toLowerCase()
                        .trim();

                const rows =
                    document.querySelectorAll(
                        targetSelector
                    );

                rows.forEach((row) => {
                    const text =
                        row.textContent
                            .toLowerCase();

                    row.style.display =
                        text.includes(
                            keyword
                        )
                            ? ""
                            : "none";
                });
            }
        );
    });
}

/* =========================================================
   DROPDOWN
   ========================================================= */

function initializeAdminDropdown() {
    const dropdowns =
        document.querySelectorAll(
            "[data-admin-dropdown]"
        );

    dropdowns.forEach((dropdown) => {
        const button =
            dropdown.querySelector(
                "[data-dropdown-button]"
            );

        const menu =
            dropdown.querySelector(
                "[data-dropdown-menu]"
            );

        if (!button || !menu) {
            return;
        }

        button.addEventListener(
            "click",
            (event) => {
                event.stopPropagation();

                document
                    .querySelectorAll(
                        "[data-admin-dropdown].open"
                    )
                    .forEach((other) => {
                        if (
                            other !==
                            dropdown
                        ) {
                            other.classList.remove(
                                "open"
                            );
                        }
                    });

                dropdown.classList.toggle(
                    "open"
                );
            }
        );
    });

    document.addEventListener(
        "click",
        () => {
            document
                .querySelectorAll(
                    "[data-admin-dropdown].open"
                )
                .forEach((dropdown) => {
                    dropdown.classList.remove(
                        "open"
                    );
                });
        }
    );
};

/* =========================================================
   DELETE CONFIRMATION
   ========================================================= */

window.confirmDelete =
    function (message) {
        return window.confirm(
            message ||
                "Data yang dipilih akan dihapus. Apakah Anda yakin?"
        );
    };

/* =========================================================
   SIDEBAR GLOBAL HELPER
   ========================================================= */

window.toggleAdminSidebar =
    function () {
        const sidebar =
            document.querySelector(
                ".admin-sidebar"
            );

        const overlay =
            document.querySelector(
                ".admin-sidebar-overlay"
            );

        if (!sidebar) {
            return;
        }

        sidebar.classList.toggle(
            "open"
        );

        if (overlay) {
            overlay.classList.toggle(
                "active"
            );
        }
    };