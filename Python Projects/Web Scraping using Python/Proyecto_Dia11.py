import bs4
import requests

# crear url sin numero de pagina
base_url = 'https://books.toscrape.com/catalogue/page-{}.html'

# lista de titulos con 4 o 5 estrellas
high_rating_titles = []

# iterar paginas
for page in range(1, 51):

    # crear sopa en cada pagina
    page_url = base_url.format(page)
    result = requests.get(page_url)
    sopa = bs4.BeautifulSoup(result.text, 'lxml')

    # seleccionar datos de los libros
    books = sopa.select('.product_pod')

    # iterar en los libros
    for book in books:

        # checar que tengan 4 o 5 estrellas
        if len(book.select('.star-rating.Four')) != 0 or len(book.select('.star-rating.Five')) != 0:

            # guardar titulo en variable
            book_title = book.select('a')[1]['title']

            # agregar libro a la lista
            high_rating_titles.append(book_title)

# ver los libros de 4 o 5 estrellas en consola
for t in high_rating_titles:
    print(t)



