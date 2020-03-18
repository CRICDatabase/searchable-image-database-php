# Cell Recognition For Inspection of Cervix

CRIC Searchable Image Database is a public cervical cell image database aiming supporting cervical cancer analysis of Pap smear.

https://cricdatabase.com.br/ used this source code until 01 July, 2020.
This code was superseded by http://github.com/cricdatabase.

## Testing (with Docker)

```
$ docker-compose up
```

The first time,
`docker-compose` will download some images.

Access [http://localhost:8080/](http://localhost:8080/) from your web browser.

To stop the containers,
press `CTRL+c`
or

```
$ docker-compose stop
```

### Update Resources

When change files,
use

```
$ docker-compose up --force-recreate
```

to update the data volume inside the containers.

### Load Database Dump

Edit `docker-compose.yml` to

```
  mysql:
    volumes:
      - "db_data:/var/lib/mysql"
      - "./mysql/initial_data:/docker-entrypoint-initdb.d"
```

and add the dump files to `./mysql/initial_data`.

