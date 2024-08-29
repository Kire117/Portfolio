from django.urls import path
from .views import ListaPendientes, DetalleTarea, CreateTask, EditTask, DeleteTask, Login, SignInPage
from django.contrib.auth.views import LogoutView

urlpatterns = [path('', ListaPendientes.as_view(), name='tasks'),
               path('login/', Login.as_view(), name='login'),
               path('logout/', LogoutView.as_view(next_page='login'), name='logout'),
               path('sign-in/', SignInPage.as_view(), name='sign-in'),
               path('task/<int:pk>', DetalleTarea.as_view(), name='task'),
               path('create-task/', CreateTask.as_view(), name='create-task'),
               path('edit-task/<int:pk>', EditTask.as_view(), name='edit-task'),
               path('delete-task/<int:pk>', DeleteTask.as_view(), name='delete-task')]

