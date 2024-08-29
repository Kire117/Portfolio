import pyttsx3
import speech_recognition as sr
import pywhatkit
import yfinance as yf
import pyjokes
import webbrowser
import datetime
import wikipedia
# voices options / language
id1_Zira = 'HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Speech\Voices\Tokens\TTS_MS_EN-US_ZIRA_11.0'
id2_Sabina = 'HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Speech\Voices\Tokens\TTS_MS_ES-MX_SABINA_11.0'

# escuchar nuestro microfono y devolver el audio como texto
def transformar_audio_en_texto():
    # almacenar recognizer en variable
    r = sr.Recognizer()

    # configurar el microfono
    with sr.Microphone() as origen:

        # tiempo de espera
        r.pause_threshold = 0.8

        # informar que comenzo la grabacion
        print("Ya puedes hablar")

        # guardar lo que escuche como audio
        audio = r.listen(origen)

        try:
            # buscar en google
            pedido = r.recognize_google_cloud(audio, language='es-MX')

            # prueba de que pudo ingresar
            print("Dijiste: " + pedido)

            # devolver a pedido
            return pedido

        # en caso de que no comprenda el audio
        except sr.UnknownValueError:

            # prueba de que no comprendio el audio
            print("Ups, no entendi")

            # devolver error
            return "Sigo esperando"

        # en caso de no resolver el pedido
        except sr.RequestError:

            # prueba de que no comprendio el audio
            print("Ups, no hay servicio")

            # devolver error
            return "Sigo esperando"

        # error inesperado
        except:
            # prueba de que no comprendio el audio
            print("Ups, algo ha salido mal")

            # devolver error
            return "Sigo esperando"


# funcion para que el asistente pueda ser escuchado
def hablar(mensaje):
    # enceder el motor de pyttsx3
    engine = pyttsx3.init()
    # set voice
    engine.setProperty('voice', id2_Sabina)

    # pronunciar mensaje
    engine.say(mensaje)
    engine.runAndWait()

# hablar('Hola papasito como estas?')
# hablar("what the dawg doing?")

# informar el dia de la semana
def pedir_dia():

    # crear variable con datos de hoy
    dia = datetime.date.today()
    print(dia)

    # crear el dia de variablel el dia de la semana
    dia_semana = dia.weekday()
    print(dia_semana)

    # diccionario
    calendar = { 0: 'Lunes',
                1 : 'Martes',
                2 : 'Miercoles',
                3 : 'Jueves',
                4 : 'Viernes',
                5 : 'Sabado',
                6 : 'Domingo'}

    # decir el dia de la semana
    hablar(f'Hoy es {calendar[dia_semana]}')

# informar que hora es
def pedir_hora():

    # crear una variable, e con datos de la hora
    hora = datetime.datetime.now()
    hora = f'En este momento son las {hora.hour} horas con {hora.minute} minutos'
    print(hora)

    #decir la hora
    hablar(hora)

# funcion saludo inicial
def saludo_inicial():

    # crear variable con datos de hora
    hora = datetime.datetime.now()
    if hora.hour < 6 or hora.hour > 20:
        momento = 'Buenas noches'
    elif 6 <= hora.hour < 13:
        momento = "Buenos días"
    else:
        momento = "Buenas tardes"

    # decir el saludo
    hablar(f"Hola {momento}, soy Sabina, tu asistente personal. Por favor, dime en que te puedo ayudar")

# funcion central del asistente
def pedir_cosas():
    # activar saludo inicial
    saludo_inicial()

    # variable de corte
    comenzar = True

    while comenzar:

        # activar el microfono y guardar el pedido en un string
        pedido = transformar_audio_en_texto().lower()

        if 'abrir youtube' in pedido:
            hablar("Con gusto, estoy abriendo Youtube")
            webbrowser.open('https://www.youtube.com')
            continue

        elif "abrir navegador" in pedido:
            hablar("Claro, estoy en eso")
            webbrowser.open("https://www.google.com")
            continue

        elif "abre spotify" in pedido:
            webbrowser.open("https://open.spotify.com/")
            continue

        elif "qué dia es hoy" in pedido:
            pedir_dia()
            continue

        elif "qué hora es" in pedido:
            pedir_hora()
            continue

        elif "busca en wikipedia" in pedido:
            hablar("Buscando en wikipedia")
            pedido = pedido.replace('busca en wikipedia', '')
            wikipedia.set_lang('es')
            resultado = wikipedia.summary(pedido, sentences=1)
            hablar("Wikipedia dice lo siguiente: ")
            hablar(resultado)
            continue

        elif "busca en internet" in pedido:
            hablar("Ya mismo estoy en eso")
            pedido = pedido.replace("busca en internet", "")
            pywhatkit.search(pedido)
            hablar("Esto es lo que he encontrado")
            continue

        elif "reproducir" in pedido:
            hablar("Buena idea, ya comienzo a reproducirlo")
            pywhatkit.playonyt(pedido)

        elif "broma" in pedido:
            hablar(pyjokes.get_joke('es'))
            continue

        elif "precio de las acciones" in pedido:
            accion = pedido.split("de")[-1].strip()
            wallet = {"apple": "APPL",
                      "amaon": "AMZN",
                      "google": "GOOGL"}

            try:
                accion_buscada = wallet[accion]
                accion_buscada = yf.Ticker(accion_buscada)
                precio_actual = accion_buscada.info['regularMarketPrice']
                hablar(f"La encontre, el precio de {accion} es {precio_actual}")
                continue
            except:
                hablar("Perdón pero no lo ha he encontrado")
                continue

        elif "adios" in pedido:
            hablar("Me voy a descansar, cualquier cosa me avisas")
            break


pedir_cosas()
