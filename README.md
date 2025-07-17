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
- (Opcionalno) Korištenje Tailwind CSS za stilizaciju

---

## Tehnologije

- **Frontend:** Vue.js / Nuxt.js  
- **Backend:** Laravel (PHP framework)  
- **Baza podataka:** MySQL ili MariaDB  
- **Stilizacija:** Tailwind CSS (opcionalno)  

---

## Instalacija i pokretanje

1. klonirajte backend repozitorij:
    ```bash
   git clone <url-backend-repozitorija>
   cd backend-folder
