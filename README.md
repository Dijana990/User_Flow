# Projekt Registracija i Upravljanje Korisnicima

## Opis projekta

Ovo je responzivna web aplikacija razvijena kao zadatak za učenje i demonstraciju rada s modernim web tehnologijama. Projekt se sastoji od dva odvojena dijela: frontend aplikacije izrađene u Vue.js/Nuxt.js i backend API-ja izrađenog u Laravelu. Komunikacija između frontenda i backenda odvija se preko REST API-ja.

### Ključne funkcionalnosti:

- Landing stranica s mogućnošću registracije i prijave korisnika
- Autentikacija korisnika s ulogama (user/admin)
- Nakon prijave, korisnik se preusmjerava na odgovarajući dashboard (/dashboard za obične korisnike, /admin za administratore)
- Administrator ima pristup frontend dashboardu gdje može raditi CRUD operacije nad korisnicima
- Korištenje Vue Routera za dinamičko prebacivanje stranica bez reload-a
- Responzivni dizajn za desktop i mobilne uređaje

---

## Tehnologije

- **Frontend:** Vue.js 
- **Backend:** Laravel (PHP framework)  
- **Baza podataka:** MySQL 
- **Stilizacija:** SCSS 

---

## Instalacija i pokretanje

1. klonirajte backend repozitorij:
    ```bash
   git clone <(https://github.com/Dijana990/User_Flow.git)>
   cd backend-folder
2. pokretanje razvojnog servera
   ```bash
   php artisan serve
3. instalacije Node.js ovisnosti
   ```bash
   npm install
4. pokretanje razvojnog servera
   ```bash
   npm run dev


