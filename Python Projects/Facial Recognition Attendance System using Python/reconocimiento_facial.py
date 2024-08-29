import cv2
import face_recognition as fr

# cargar imagenes
foto_control = fr.load_image_file('FotoA.jpg')
foto_prueba = fr.load_image_file('FotoB.jpg')

# pasar imagenes a rgb
foto_control = cv2.cvtColor(foto_control, cv2.COLOR_BGR2RGB)
foto_prueba = cv2.cvtColor(foto_prueba, cv2.COLOR_BGR2RGB)

# localizar cara control
lugar_cara_A = fr.face_locations(foto_control)[0]
cara_codificada_A = fr.face_encodings(foto_control)[0]

# print(lugar_cara_A)
# mostrar rectangulo en cara A
cv2.rectangle(foto_control,
              (lugar_cara_A[3], lugar_cara_A[0]),
              (lugar_cara_A[1], lugar_cara_A[2]),
              (0, 255, 0),
              2)

# localizar cara control
lugar_cara_B = fr.face_locations(foto_prueba)[0]
cara_codificada_B = fr.face_encodings(foto_prueba)[0]

# mostrar rectangulo en cara B
cv2.rectangle(foto_prueba,
              (lugar_cara_B[3], lugar_cara_B[0]),
              (lugar_cara_B[1], lugar_cara_B[2]),
              (0, 255, 0),
              2)

# realizar comparacion
resultado = fr.compare_faces([cara_codificada_A] , cara_codificada_B) # donde la tolerancia si es mayor a 0.6
# dira que no hay parecido pero si es menor a 0.6 dira que si hay parecido, ahora lo que se puede hacer, es modificar esa tolencia para
# hacerlo mas flexible a la hora de comparar entre caras o hacerlo mas estricto donde valores menores seran True y mayores False

# print(resultado) al imprimir el resultado en pantalla lo que hara es ver si ambas caras concinden y dependiendo del resultado devolver True = si es cierto o
# False = si no es cierto

# medida de la distancia
distancia = fr.face_distance([cara_codificada_A], cara_codificada_B)

# mostrat resultado
cv2.putText(foto_prueba, f'{resultado} {distancia.round(2)}',
            (50, 50),
            cv2.FONT_HERSHEY_COMPLEX,
            1,
            (0, 255, 0),
            2)

# mostrar imagenes
cv2.imshow('Foto Control', foto_control)
cv2.imshow('Foto Prueba', foto_prueba)

# mantener programa abierto
cv2.waitKey(0)


