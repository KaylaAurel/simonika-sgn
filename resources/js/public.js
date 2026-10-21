/* =========================================================
   SIMONIKA SGN
   PUBLIC JAVASCRIPT
   ========================================================= */

document.addEventListener(
    "DOMContentLoaded",
    () => {
        initializePublicMenu();
        initializeEmployeeSearch();
        initializeScrollEffects();
    }
);

/* =========================================================
   MOBILE MENU
   ========================================================= */

function initializePublicMenu() {
    const toggle =
        document.querySelector(
            ".public-menu-toggle"
        );

    const menu =
        document.querySelector(
            ".public-nav"
        );

    if (!toggle || !menu) {
        return;
    }

    toggle.addEventListener(
        "click",
        () => {
            menu.classList.toggle("open");

            const isOpen =
                menu.classList.contains(
                    "open"
                );

            toggle.setAttribute(
                "aria-expanded",
                isOpen
            );
        }
    );

    menu
        .querySelectorAll(
            ".public-nav-link"
        )
        .forEach((link) => {
            link.addEventListener(
                "click",
                () => {
                    menu.classList.remove(
                        "open"
                    );

                    toggle.setAttribute(
                        "aria-expanded",
                        "false"
                    );
                }
            );
        });
}

/* =========================================================
   EMPLOYEE SEARCH
   ========================================================= */

function initializeEmployeeSearch() {
    const input =
        document.getElementById(
            "employeeSearch"
        );

    const cards =
        document.querySelectorAll(
            "[data-employee-card]"
        );

    const empty =
        document.querySelector(
            "[data-search-empty]"
        );

    if (!input || !cards.length) {
        return;
    }

    input.addEventListener(
        "input",
        () => {
            const keyword =
                input.value
                    .toLowerCase()
                    .trim();

            let visibleCount = 0;

            cards.forEach((card) => {
                const searchText =
                    (
                        card.dataset.search ||
                        card.textContent
                    ).toLowerCase();

                const visible =
                    searchText.includes(
                        keyword
                    );

                card.style.display =
                    visible
                        ? ""
                        : "none";

                if (visible) {
                    visibleCount++;
                }
            });

            if (empty) {
                empty.style.display =
                    visibleCount === 0
                        ? "block"
                        : "none";
            }
        }
    );
}

/* =========================================================
   SCROLL EFFECT
   ========================================================= */

function initializeScrollEffects() {
    const navbar =
        document.querySelector(
            ".public-navbar"
        );

    if (!navbar) {
        return;
    }

    window.addEventListener(
        "scroll",
        () => {
            if (
                window.scrollY > 20
            ) {
                navbar.classList.add(
                    "scrolled"
                );
            } else {
                navbar.classList.remove(
                    "scrolled"
                );
            }
        },
        {
            passive: true,
        }
    );
}

/* =========================================================
   SEARCH HELPER
   ========================================================= */

window.searchEmployee = function (
    inputId,
    cardSelector
) {
    const input =
        document.getElementById(
            inputId
        );

    if (!input) {
        return;
    }

    const keyword =
        input.value
            .toLowerCase()
            .trim();

    document
        .querySelectorAll(
            cardSelector
        )
        .forEach((card) => {
            const text =
                card.textContent.toLowerCase();

            card.style.display =
                text.includes(keyword)
                    ? ""
                    : "none";
        });
};