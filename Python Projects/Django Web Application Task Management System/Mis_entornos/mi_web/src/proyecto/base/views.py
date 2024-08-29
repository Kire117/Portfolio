from django.shortcuts import render, redirect
from django.views.generic.list import ListView
from django.views.generic.detail import DetailView
from django.views.generic.edit import CreateView, UpdateView, DeleteView, FormView
from django.contrib.auth.forms import UserCreationForm
from django.contrib.auth import login
from django.urls import reverse_lazy
from django.contrib.auth.views import LoginView
from django.contrib.auth.mixins import LoginRequiredMixin
from .models import Task


# Create your views here.

class Login(LoginView):
    template_name = 'base/login.html'
    field = '__all__'
    redirect_authenticated_user = True

    def get_success_url(self):
        return reverse_lazy('tasks')

class SignInPage(FormView):
    template_name = 'base/sign-in.html'
    form_class = UserCreationForm
    redirect_authenticated_user = True
    success_url = reverse_lazy('tasks')

    def form_valid(self, form):
        user = form.save()
        if user is not None:
            login(self.request, user)
        return super(SignInPage, self).form_valid(form)

    def get(self, *args, **kwargs):
        if self.request.user.is_authenticated:
            return redirect('tasks')
        return super(SignInPage, self).get(*args, **kwargs)

class ListaPendientes(LoginRequiredMixin, ListView):
    model = Task
    context_object_name = 'tasks'

    def get_context_data(self, **kwarg):
        context = super().get_context_data(**kwarg)
        context['tasks'] = context['tasks'].filter(user=self.request.user)
        context['count'] = context['tasks'].filter(complete=False).count()
        # para buscar en la caja de texto
        searched_word = self.request.GET.get('search-area') or ''
        if searched_word:
            context['tasks'] = context['tasks'].filter(title__icontains=searched_word)
        context['searched_word'] = searched_word
        return context

class DetalleTarea(LoginRequiredMixin, DetailView):
    model = Task
    context_object_name = 'task'
    template_name = 'base/task.html' # esto es para buscar directamente el template con el nombre que le hayamos asignado a la pagina hmtl

class CreateTask(LoginRequiredMixin, CreateView):
    model = Task
    fields = ['title', 'desc', 'complete'] # esto es para agregar todos los contenidos para crear el formulario dentro del models.py Task
    success_url = reverse_lazy('tasks')

    def form_valid(self, form):
        form.instance.user = self.request.user
        return super(CreateTask, self).form_valid(form)

class EditTask(LoginRequiredMixin, UpdateView):
    model = Task
    fields = ['title', 'desc', 'complete']  # esto es para agregar todos los contenidos para crear el formulario dentro del models.py Task
    success_url = reverse_lazy('tasks')

class DeleteTask(LoginRequiredMixin, DeleteView):
    model = Task
    context_object_name = 'task'
    success_url = reverse_lazy('tasks')
