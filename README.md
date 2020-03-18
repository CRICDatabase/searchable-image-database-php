# Cell Recognition For Inspection of Cervix

CRIC Searchable Image Database is a public cervical cell image database aiming supporting cervical cancer analysis of Pap smear.

https://cricdatabase.com.br/ used this source code until 01 July, 2020.
This code was superseded by http://github.com/cricdatabase.

## Testing (with Docker)

The first time,
you need to create the Docker image.

```
$ docker build -t cric1.0 .
```

After create the image,
you can run the container with

```
$ docker run -p 8080:80 -d cric1.0
```

Access [http://localhost:8080/](http://localhost:8080/) from your web browser.

To stop the container,
execute

```
$ docker ps
$ docker stop CONTAINER
```

where `CONTAINER` is listed in the output of `docker ps`.