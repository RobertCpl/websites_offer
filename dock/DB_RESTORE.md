## Procedura przywracania bazy danych (MySQL w Dockerze)

Poniżej jest prosty i bezpieczny flow: zrzut -> przeslanie -> import.

### 1) Dump z lokalnego kontenera

Przykladowa komenda (najczesciej z `root` i bez tablespaces):

```
docker exec -i <LOCAL_MYSQL_CONTAINER> mysqldump -uroot -p --no-tablespaces <DB_NAME> > /tmp/db.sql
```

Uwaga:
- Jesli chcesz uzyc innego usera, podmien `-uroot` na `-u<DB_USER>`.
- `--no-tablespaces` omija wymaganie uprawnienia `PROCESS`.

### 2) Przeslanie dumpa na serwer (SCP)

```
scp /tmp/db.sql <USER>@<SERVER>:/tmp/db.sql
```

### 3) Wgranie do kontenera i import

#### A) Plik jest na serwerze (host)

```
ssh <USER>@<SERVER> "docker exec -i <PROD_MYSQL_CONTAINER> mysql -uroot -p <DB_NAME> < /tmp/db.sql"
```

#### B) Plik jest w kontenerze

Najpierw skopiuj plik do kontenera:

```
ssh <USER>@<SERVER> "docker cp /tmp/db.sql <PROD_MYSQL_CONTAINER>:/tmp/db.sql"
```

Potem zrob import wewnatrz kontenera:

```
ssh <USER>@<SERVER> "docker exec -i <PROD_MYSQL_CONTAINER> sh -c \"mysql -uroot -p <DB_NAME> < /tmp/db.sql\""
```

### 4) Opcjonalnie: aktualizacja URL w WordPress

Jesli zmienia sie domena:

```
docker exec -i <PROD_WP_CONTAINER> wp search-replace 'http://stary-url' 'https://nowa-domena.pl' --all-tables
```
