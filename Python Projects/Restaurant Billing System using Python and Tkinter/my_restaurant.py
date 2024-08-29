from tkinter import *
import random
import datetime
from tkinter import filedialog, messagebox
#
operator = ''
food_prices = [1.32, 1.65, 2.31, 3.22, 1.22, 1.99, 2.05, 2.65]
drink_prices = [0.25, 0.99, 1.21, 1.54, 1.08, 1.10, 2.00, 1.58]
dessert_prices = [1.54, 1.68, 1.32, 1.97, 2.55, 2.14, 1.94, 1.74]

def click_button(num):
    global operator
    operator = operator + num
    calculator_visor.delete(0, END)
    calculator_visor.insert(END, operator)

def erase():
    global operator
    operator = ''
    calculator_visor.delete(0, END)

def get_result():
    global operator
    result = str(eval(operator))
    calculator_visor.delete(0, END)
    calculator_visor.insert(0, result)
    operator = ''

def revisar_check():
    x = 0 # checar para panel de comida
    for f in food_pictures:
        if food_variables[x].get() == 1:
            food_pictures[x].config(state=NORMAL)
            if food_pictures[x].get() == '0':
                food_pictures[x].delete(0, END)
            food_pictures[x].focus()
        else:
            food_pictures[x].config(state=DISABLED)
            food_text[x].set('0')
        x += 1

    x = 0 # checar para panel de bebidas
    for f in drink_pictures:
        if drink_variables[x].get() == 1:
            drink_pictures[x].config(state=NORMAL)
            if drink_pictures[x].get() == '0':
                drink_pictures[x].delete(0, END)
            drink_pictures[x].focus()
        else:
            drink_pictures[x].config(state=DISABLED)
            drink_text[x].set('0')
        x += 1

    x = 0 # checar para panel de postres
    for f in dessert_pictures:
        if dessert_variables[x].get() == 1:
            dessert_pictures[x].config(state=NORMAL)
            if dessert_pictures[x].get() == '0':
                dessert_pictures[x].delete(0, END)
            dessert_pictures[x].focus()
        else:
            dessert_pictures[x].config(state=DISABLED)
            dessert_text[x].set('0')
        x += 1

def total():
    sub_total_food = 0
    index = 0
    for quantity in food_text:
        sub_total_food = sub_total_food + (float(quantity.get()) * food_prices[index])
        index += 1

    sub_total_drink = 0
    index = 0
    for quantity in drink_text:
        sub_total_drink = sub_total_drink + (float(quantity.get()) * drink_prices[index])
        index += 1

    sub_total_dessert = 0
    index = 0
    for quantity in dessert_text:
        sub_total_dessert = sub_total_dessert + (float(quantity.get()) * dessert_prices[index])
        index += 1

    sub_total = sub_total_food + sub_total_drink + sub_total_dessert
    tax = sub_total * 0.13 # impuestos en canada :(
    total = sub_total + tax

    var_cost_food.set(f"$ {round(sub_total_food, 2)}")
    var_cost_drink.set(f"$ {round(sub_total_drink, 2)}")
    var_cost_dessert.set(f"$ {round(sub_total_dessert, 2)}")
    var_subtotal.set(f'$ {round(sub_total, 2)}')
    var_tax.set(f'$ {round(tax, 2)}')
    var_total.set(f'$ {round(total, 2)}')

def ticket():
    text_ticket.delete(1.0, END)
    ticket_num = f'N# - {random.randint(1000,1999)}'
    date = datetime.datetime.now()
    date_ticket = f'{date.day}/{date.month}/{date.year} - {date.hour}:{date.minute}'
    text_ticket.insert(END, f'Data: \t{ticket_num}\t\t{date_ticket}' + '\n')
    text_ticket.insert(END, f'*' * 75 + '\n')
    text_ticket.insert(END, 'Items:\t\tQty\tCost Items\n')
    text_ticket.insert(END, f'-' * 90 + '\n')

    x = 0
    # comidas
    for food in food_text:
        if food.get() != '0':
            text_ticket.insert(END, f'{foods_list[x]}\t\t{food.get()}\t$ {int(food.get()) * food_prices[x]}\n')
        x += 1

    # bebidas
    x = 0
    for drink in drink_text:
        if drink.get() != '0':
            text_ticket.insert(END, f'{drinks_list[x]}\t\t{drink.get()}\t$ {int(drink.get()) * drink_prices[x]}\n')
        x += 1

    # bebidas
    x = 0
    for dessert in dessert_text:
        if dessert.get() != '0':
            text_ticket.insert(END, f'{desserts_list[x]}\t\t{dessert.get()}\t'
                                    f'$ {int(dessert.get()) * dessert_prices[x]}\n')
        x += 1

    text_ticket.insert(END, f'-' * 90 + '\n')
    text_ticket.insert(END, f'Food Costs: \t\t\t{var_cost_food.get()}\n')
    text_ticket.insert(END, f'Drink Costs: \t\t\t{var_cost_drink.get()}\n')
    text_ticket.insert(END, f'Dessert Costs: \t\t\t{var_cost_dessert.get()}\n')
    text_ticket.insert(END, f'-' * 90 + '\n')
    text_ticket.insert(END, f'Subtotal: \t\t\t{var_subtotal.get()}\n')
    text_ticket.insert(END, f'Taxes: \t\t\t{var_tax.get()}\n')
    text_ticket.insert(END, f'Total: \t\t\t{var_total.get()}\n')
    text_ticket.insert(END, f'*' * 75 + '\n')
    text_ticket.insert(END, 'We hope to see you soon! Have a great day!')

def save():
    saved_data = text_ticket.get(1.0, END)
    file = filedialog.asksaveasfile(mode='w', defaultextension='.txt')
    file.write(saved_data)
    file.close()
    messagebox.showinfo("Information", "Your ticket has been saved")

def reset():
    text_ticket.delete(0.1, END)
    for text in food_text:
        text.set('0')
    for text in drink_text:
        text.set('0')
    for text in dessert_text:
        text.set('0')
    for square in food_pictures:
        square.config(state=DISABLED)
    for square in drink_pictures:
        square.config(state=DISABLED)
    for square in dessert_pictures:
        square.config(state=DISABLED)
    for var in food_variables:
        var.set(0)
    for var in drink_variables:
        var.set(0)
    for var in dessert_variables:
        var.set(0)

    var_cost_food.set('')
    var_cost_drink.set('')
    var_cost_dessert.set('')
    var_subtotal.set('')
    var_tax.set('')
    var_total.set('')
# iniciar tkinter
app = Tk()

# tamano de la ventana
app.geometry('1120x630+0+0')  # pide parametros como tamano y ubicacion

# evitar maximiar
app.resizable(False, False)

# titulo ventana
app.title('My Restaurant - Billing System')

# color de fondo de la ventana
app.config(bg='burlywood')  # bg = background

# panel superior
superior_panel = Frame(app, bd=1, relief=RAISED)
''' existen varios tipos de relief como FLAT, RAISED, SUNKEN, GROOVE Y RIDGE'''
superior_panel.pack(side=TOP)

# etiqueta titulo
title_label = Label(superior_panel, text="Billing System", fg='azure4',
                    font=('Dosis', 58), bg='burlywood', width=27)  # fg = foreground
title_label.grid(row=0, column=0)  # donde te pide el lugar

# panel izquierdo
left_panel = Frame(app, bd=1, relief=RAISED)
left_panel.pack(side=LEFT)

# panel costos
costs_panel = Frame(left_panel, bd=1, relief=RAISED, bg='azure4', padx=50)
costs_panel.pack(side=BOTTOM)

# panel comidas
food_panel = LabelFrame(left_panel, text='Foods', font=('Dosis', 19, 'bold'),
                        bd=1, relief=RAISED, fg='azure4')
food_panel.pack(side=LEFT)

# panel bebidas
drinks_panel = LabelFrame(left_panel, text='Drinks', font=('Dosis', 19, 'bold'),
                          bd=1, relief=RAISED, fg='azure4')
drinks_panel.pack(side=LEFT)

# panel postres
desserts_panel = LabelFrame(left_panel, text='Desserts', font=('Dosis', 19, 'bold'),
                            bd=1, relief=RAISED, fg='azure4')
desserts_panel.pack(side=LEFT)

# panel derecha
right_panel = Frame(app, bd=1, relief=RAISED)
right_panel.pack(side=RIGHT)

# panel calculadora
calculator_panel = Frame(right_panel, bd=1, relief=RAISED, bg="burlywood")
calculator_panel.pack()

# panel recibo
ticket_panel = Frame(right_panel, bd=1, relief=RAISED, bg="burlywood")
ticket_panel.pack()

# panel botones
buttons_panel = Frame(right_panel, bd=1, relief=RAISED, bg="burlywood")
buttons_panel.pack()

# lista de productos
foods_list = ['Chicken', 'Beef', 'Salmon', 'Kebab', 'Merluza', 'Pizza1', 'Pizza2', 'Pizza3']
drinks_list = ['Water', 'Soda', 'Juice', 'Cola', 'Wine1', 'Wine2', 'Beer1', 'Beer2']
desserts_list = ['Ice Cream', 'Fruit', 'Brownies', 'Flan', 'Mousse', 'Cake1', 'Cake2', 'Cake3']

# generar items comida
food_variables = []
food_pictures = []
food_text = []
count = 0
for food in foods_list:
    # crear checkbutton
    food_variables.append('')
    food_variables[count] = IntVar()
    food = Checkbutton(food_panel, text=food.title(), font=('Dosis', 19, 'bold'),
                       onvalue=1, offvalue=0, variable=food_variables[count], command=revisar_check)
    food.grid(row=count, column=0, sticky=W)

    # crear cuadros de entrada
    food_pictures.append('')
    food_text.append('')
    food_text[count] = StringVar()
    food_text[count].set(0)

    food_pictures[count] = Entry(food_panel, font=('Dosis', 18, 'bold'),
                                 bd=1, width=6, state=DISABLED, textvariable=food_text[count])
    food_pictures[count].grid(row=count, column=1)
    count += 1

# generar items bebidas
drink_variables = []
drink_pictures = []
drink_text = []
count = 0
for drink in drinks_list:
    # crear checkbutton
    drink_variables.append('')
    drink_variables[count] = IntVar()
    drink = Checkbutton(drinks_panel, text=drink.title(), font=('Dosis', 19, 'bold'),
                        onvalue=1, offvalue=0, variable=drink_variables[count], command=revisar_check)
    drink.grid(row=count, column=0, sticky=W)

    # crear cuadros de bebidas
    drink_pictures.append('')
    drink_text.append('')
    drink_text[count] = StringVar()
    drink_text[count].set(0)

    drink_pictures[count] = Entry(drinks_panel, font=('Dosis', 18, 'bold'),
                                  bd=1, width=6, state=DISABLED, textvariable=drink_text[count])
    drink_pictures[count].grid(row=count, column=1)
    count += 1

# generar items postres
dessert_variables = []
dessert_pictures = []
dessert_text = []
count = 0
for dessert in desserts_list:
    # crear checkbuttons
    dessert_variables.append('')
    dessert_variables[count] = IntVar()
    dessert = Checkbutton(desserts_panel, text=dessert.title(), font=('Dosis', 19, 'bold'),
                          onvalue=1, offvalue=0, variable=dessert_variables[count], command=revisar_check)
    dessert.grid(row=count, column=0, sticky=W)
    # crear cuadro de postres
    dessert_pictures.append('')
    dessert_text.append('')
    dessert_text[count] = StringVar()
    dessert_text[count].set(0)

    dessert_pictures[count] = Entry(desserts_panel, font=('Dosis', 18, 'bold'),
                                    bd=1, width=6, state=DISABLED, textvariable=dessert_text[count])
    dessert_pictures[count].grid(row=count, column=1)
    count += 1

# variables
var_cost_food = StringVar()
var_cost_drink = StringVar()
var_cost_dessert = StringVar()
var_subtotal = StringVar()
var_tax = StringVar()
var_total = StringVar()

# etiquetas de costo comida y campos de entrada
label_cost_food = Label(costs_panel, text='Meals Costs', font=('Dosis', 12, 'bold'),
                        bg='azure4', fg='white')
label_cost_food.grid(row=0, column=0)

text_cost_food = Entry(costs_panel, font=('Dosis', 12, 'bold'), bd=1,
                       width=10, state='readonly', textvariable=var_cost_food)
text_cost_food.grid(row=0, column=1, padx=41)

# etiquetas de costo bebida y campos de entrada
label_cost_drink = Label(costs_panel, text='Drinks Costs', font=('Dosis', 12, 'bold'),
                         bg='azure4', fg='white')
label_cost_drink.grid(row=1, column=0)

text_cost_drink = Entry(costs_panel, font=('Dosis', 12, 'bold'), bd=1,
                        width=10, state='readonly', textvariable=var_cost_drink)
text_cost_drink.grid(row=1, column=1, padx=41)

# etiquetas de costo bebida y campos de entrada
label_cost_dessert = Label(costs_panel, text='Desserts Costs', font=('Dosis', 12, 'bold'),
                           bg='azure4', fg='white')
label_cost_dessert.grid(row=2, column=0)

text_cost_dessert = Entry(costs_panel, font=('Dosis', 12, 'bold'), bd=1,
                          width=10, state='readonly', textvariable=var_cost_dessert)
text_cost_dessert.grid(row=2, column=1, padx=41)

# etiquetas de costo subtotal y campos de entrada
label_subtotal = Label(costs_panel, text='Subtotal', font=('Dosis', 12, 'bold'),
                       bg='azure4', fg='white')
label_subtotal.grid(row=0, column=2)

text_subtotal = Entry(costs_panel, font=('Dosis', 12, 'bold'), bd=1,
                      width=10, state='readonly', textvariable=var_subtotal)
text_subtotal.grid(row=0, column=3, padx=41)

# etiquetas de impuesto subtotal y campos de entrada
label_tax = Label(costs_panel, text='Taxes', font=('Dosis', 12, 'bold'),
                  bg='azure4', fg='white')
label_tax.grid(row=1, column=2)

text_tax = Entry(costs_panel, font=('Dosis', 12, 'bold'), bd=1,
                 width=10, state='readonly', textvariable=var_tax)
text_tax.grid(row=1, column=3, padx=41)

# etiquetas de costo total y campos de entrada
label_total = Label(costs_panel, text='Total', font=('Dosis', 12, 'bold'),
                    bg='azure4', fg='white')
label_total.grid(row=2, column=2)

text_total = Entry(costs_panel, font=('Dosis', 12, 'bold'), bd=1,
                   width=10, state='readonly', textvariable=var_total)
text_total.grid(row=2, column=3, padx=41)

# botones
buttons = ['Total', 'Ticket', 'Save', 'Reset']
created_buttons = []

columns = 0
for button in buttons:
    button = Button(buttons_panel, text=button.title(), font=('Dosis', 14, 'bold'),
                    fg='white', bg='azure4', bd=1, width=9)

    created_buttons.append(button)

    button.grid(row=0, column=columns)
    columns += 1

created_buttons[0].config(command=total)
created_buttons[1].config(command=ticket)
created_buttons[2].config(command=save)
created_buttons[3].config(command=reset)

# area de recibo
text_ticket = Text(ticket_panel, font=('Dosis', 12, 'bold'), bd=1, width=50, height=10)
text_ticket.grid(row=0, column=0)

# calculadora
calculator_visor = Entry(calculator_panel, font=('Dosis', 16, 'bold'), width=37, bd=1)
calculator_visor.grid(row=0, column=0, columnspan=4)

calculator_buttons = ['7', '8', '9', '+',
                      '4', '5', '6', '-',
                      '1', '2', '3', 'X',
                      '.', 'Erase', '0', '/','=']

saved_buttons = []
fila = 1
columna = 0

for button in calculator_buttons:
    button = Button(calculator_panel, text=button.title(), font=('Dosis', 16, 'bold'),
                    fg='white', bg='azure4', bd=1, width=8)

    saved_buttons.append(button)

    button.grid(row=fila, column=columna)
    if columna == 3:
        fila += 1

    columna += 1

    if columna == 4:
        columna = 0

saved_buttons[0].config(command=lambda: click_button('7'))
saved_buttons[1].config(command=lambda: click_button('8'))
saved_buttons[2].config(command=lambda: click_button('9'))
saved_buttons[3].config(command=lambda: click_button('+'))
saved_buttons[4].config(command=lambda: click_button('4'))
saved_buttons[5].config(command=lambda: click_button('5'))
saved_buttons[6].config(command=lambda: click_button('6'))
saved_buttons[7].config(command=lambda: click_button('-'))
saved_buttons[8].config(command=lambda: click_button('1'))
saved_buttons[9].config(command=lambda: click_button('2'))
saved_buttons[10].config(command=lambda: click_button('3'))
saved_buttons[11].config(command=lambda: click_button('*'))
saved_buttons[12].config(command=lambda: click_button('.'))
saved_buttons[13].config(command=erase)
saved_buttons[14].config(command=lambda: click_button('0'))
saved_buttons[15].config(command=lambda: click_button('/'))
saved_buttons[16].config(command=get_result)


# evitar que la pantalla se ciere
app.mainloop()
