# Black Brew Coffee

Custom WordPress theme for a specialty coffee shop brand. The project is built as a custom theme with Vite, Tailwind CSS, TypeScript and WordPress template structure.

## Opis projektu

Motyw Black Brew Coffee jest przeznaczony do obsługi strony kawiarni z sekcjami:
- hero / prezentacja marki,
- menu i oferty,
- sekcje o kawie i procesie,
- galeria,
- niestandardowe typy wpisów i pola ACF,
- responsywny layout dostosowany do urządzeń mobilnych.

## Stack technologiczny

- WordPress
- PHP
- Tailwind CSS
- TypeScript
- Vite
- Advanced Custom Fields (ACF)

## Wymagania

- WordPress 5.9+ / pełny motyw blokowy (FSE-friendly)
- PHP 8+
- Node.js 18+
- npm
- plugin ACF

## Instalacja

1. Skopiuj ten folder do katalogu `wp-content/themes/` w instalacji WordPress.
2. W panelu WordPress aktywuj motyw `Black Brew Coffee`.
3. Zainstaluj i aktywuj wtyczkę `Advanced Custom Fields`.
4. Zainstaluj zależności frontendowe:

```bash
npm install
```

## Dewelopment

Uruchom tryb deweloperski:

```bash
npm run dev
```

Budowanie wersji produkcyjnej:

```bash
npm run build
```

Obserwowanie zmian w czasie rzeczywistym:

```bash
npm run watch
```

## Struktura projektu

```bash
.
├── assets/                 # statyczne zasoby projektu
├── inc/                    # pliki PHP z custom post types i polami ACF
├── parts/                  # części szablonów WordPress
├── src/
│   ├── css/                # style źródłowe
│   └── ts/                 # skrypty TypeScript
├── templates/              # szablony stron i układów
├── functions.php           # rejestracja motywu i enqueue
├── header.php              # nagłówek
├── footer.php              # stopka
├── index.php               # główny szablon
├── style.css              # metadata motywu i nagłówek WordPress
├── package.json           # skrypty i zależności frontendowe
├── vite.config.ts         # konfiguracja Vite
├── tailwind.config.js     # konfiguracja Tailwind
├── postcss.config.js      # konfiguracja PostCSS
├── tsconfig.json          # konfiguracja TypeScript
└── README.md
```

## Funkcje motywu

- osobny system CSS i JS z bundlowaniem przez Vite,
- integracja z Tailwind CSS,
- gotowe menu główne i footer,
- wsparcie dla custom post types,
- support dla ACF i pol niestandardowych,
- responsywny design z motywem premium coffee brand.

## Rozwój i dostosowanie

W przypadku zmian wyglądu główne pliki do edycji:
- `src/css/app.css` — główne style projektu,
- `src/ts/app.ts` — logika frontendowa,
- `functions.php` — konfiguracja motywu i zasobów,
- `inc/custom-post-types.php` — rejestracja custom post types,
- `inc/acf-fields.php` — definicje pól ACF.

## Licencja

Ten projekt jest udostępniany na licencji GNU General Public License v2 or later.

## Autor

Black Brew Coffee

---

Jeśli chcesz, mogę też przygotować wersję:
- bardziej „premium” / brandową,
- bardziej techniczną dla zespołu,
- albo skróconą wersję pod GitHub z sekcją „Features / Setup / Contributing”.
