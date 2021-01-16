<template>
  <div>
    <hr />
    <div class="row">
      <div class="col">
        <button type="button" data-toggle="modal" v-on:click="listar_usuarios()" data-target="#modalcrear"
          class="btn btn-success">
          Nuevo registro
        </button>
      </div>
    </div>
    <hr />

    <h1>Administración de Registros</h1>

    <div v-show=alerta_eliminar class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong v-text="respuesta"></strong>
      <button type="button" class="close" v-on:click="cerrar()" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

    <!-- tabla -->
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Title</th>
          <th scope="col">Completed</th>
          <th scope="col">User</th>
          <th scope="col">Editar</th>
          <th scope="col">Eliminiar</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in todos" :key="item.id">
          <th v-text="item.title"></th>
          <td>
            <div v-if="item.completed == true">
              <span class="badge badge-success">{{ item.completed }}</span>
            </div>
            <div v-else>
              <span class="badge badge-warning">{{ item.completed }}</span>
            </div>
          </td>

          <th v-text="item.userId"></th>

          <td>
            <button class="btn btn-info" v-on:click="abrirModal(item)">Editar</button>
          </td>

          <td>
            <button class="btn btn-danger" v-on:click="abrirModalConfirmar(item)">Eliminiar</button>
          </td>
        </tr>
      </tbody>
    </table>
    <hr />
    <!-- fin tabla -->

    <!-- Modal nuevo -->
    <div class="modal fade" id="modalcrear" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2>Nuevo Registro</h2>
          </div>
          <div class="modal-body">


            <div v-show=alerta class="alert alert-info alert-dismissible fade show" role="alert">
              <strong v-text="respuesta"></strong>
              <button type="button" class="close" v-on:click="cerrar()" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>


            <form v-on:submit.prevent>

              <div class="form-row">
                <div class="form-group col-md-12">
                  <label>Title:</label>
                  <input type="text" max="100" v-model="title" class="form-control" placeholder="Title" />
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-12">
                  <label>Completed:</label>
                  <select class="form-control" v-model="completed">
                    <option value="" disabled selected>Seleccionar...</option>
                    <option value=true>True</option>
                    <option value=false>False</option>
                  </select>
                </div>
              </div>


              <div class="form-row">
                <div class="form-group col-md-12">
                  <label>User:</label>
                  <select class="form-control" v-model="userId">
                    <option value="" disabled selected>Seleccionar...</option>
                    <option v-for="item in users" :key="item.id" v-bind:value="item.id">{{item.name}}</option>
                  </select>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" data-dismiss="modal" v-on:click="cancelar()" class="btn btn-secondary">
                  Cancelar
                </button>

                <button type="button" id="Agregar" :disabled="isDisabled" v-on:click="crear()" class="btn btn-success">
                  Agregar
                </button>
              </div>
            </form>


          </div>
        </div>
      </div>
    </div>
    <!--fin Modal nuevo -->

    <!-- Modal editar -->
    <div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2>Actualizar registro</h2>
          </div>
          <div class="modal-body">

            <div v-show=alerta class="alert alert-info alert-dismissible fade show" role="alert">
              <strong v-text="respuesta"></strong>
              <button type="button" class="close" v-on:click="cerrar()" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form v-on:submit.prevent>
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label>Title:</label>
                  <input type="text" max="50" v-model="title" class="form-control" placeholder="Nombre" />
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-12">
                  <label>Completed:</label>
                  <select class="form-control" v-model="completed">
                    <option value="true">True</option>
                    <option value="false">False</option>
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-12">
                  <label>User:</label>
                  <select class="form-control" v-model="userId">
                    <option v-for="item in users" :key="item.id" v-bind:value="item.id">{{item.name}}</option>
                  </select>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" data-dismiss="modal" v-on:click="cancelar()" class="btn btn-secondary">
                  Cancelar
                </button>

                <button type="button" :disabled="isDisabledEditar" v-on:click="actualizar()" class="btn btn-success">
                  Actualizar
                </button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
    <!--fin Modal editar -->

    <!-- Modal confirmar eliminar -->
    <div class="modal fade" id="ModalConfirmarBorrar" tabindex="-1" role="dialog">
      <div class="modal-dialog" style="max-width: 600px" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h1>Realmente quiere borrarlo?</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" v-on:click="cancelar()" class="btn btn-secondary">
              Cancelar
            </button>
            <button type="button" v-on:click="eliminar()" class="btn btn-success">Confirmar</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
  export default {
    data() {
      return {
        id: "",
        title: "",
        completed: "",
        userId: '',
        todos: [],
        users: [],
        alerta: false,
        alerta_eliminar: false,
        respuesta: '',
      };
    },
    methods: {
      listar() {
        var url = "/api/todos";
        axios.get(url).then((response) => (this.todos = response.data));
      },

      listar_usuarios() {
        var url = "/api/users";
        axios.get(url).then((response) => (this.users = response.data));
      },

      crear() {
        axios
          .post("/api/todos", {
            title: this.title,
            completed: this.completed,
            userId: this.userId,
          })
          .then(response => {
            this.respuesta = "Registro creado con éxito";
            this.alerta = true;
            this.limpiar();

          })
          .catch(error => {
            console.log(error);
            this.respuesta = "Error al crear el registro";
            this.alerta = true;
          })

        //realizar nuevamente la consulta
        this.listar();
      },

      actualizar() {
        //enviar peticion
        axios
          .put("/api/todos/" + this.id, {
            title: this.title,
            completed: this.completed,
            userId: this.userId,
          })
          .then(response => {
            this.respuesta = "Registro actualizado con éxito";
            this.alerta = true;
          })
          .catch(error => {
            console.log(error);
            this.respuesta = "Error al actualizar registro";
            this.alerta = true;
          })

        //realizar nuevamente la consulta
        this.listar();
      },

      eliminar() {
        //enviar peticion
        axios
          .delete("/api/todos/" + this.id, { params: { id: this.id } })
          .then(response => {
            this.respuesta = "Registro eliminado con éxito";
            this.alerta_eliminar = true;
          })
          .catch(error => {
            console.log(error);
            this.respuesta = "Error al eliminar registro";
            this.alerta_eliminar = true;
          })

        //llamar al metodo cancelar
        this.cancelar();

        //realizar nuevamente la consulta
        this.listar();
      },

      abrirModal(objeto) {
        //colocar valores para actualiar
        this.id = objeto.id;
        this.title = objeto.title;
        this.completed = objeto.completed;
        this.userId = objeto.userId;

        //cargar users
        this.listar_usuarios();

        //abrir modal
        $("#modalUpdate").modal("show");
      },

      //abrir modal confirmar
      abrirModalConfirmar(objeto) {
        this.id = objeto.id;
        $("#ModalConfirmarBorrar").modal("show");
      },

      limpiar() {
        //colocar valores en blanco
        this.id = "";
        this.title = "";
        this.completed = "";
        this.userId = "";
      },

      cancelar() {
        //colocar valores en blanco
        this.id = "";
        this.title = "";
        this.completed = "";
        this.userId = "";

        //respuestas
        this.alerta = false;
        this.respuesta = '';

        //cerrar los modal
        $("#modalcrear").modal("hide");
        $("#modalUpdate").modal("hide");
        $("#ModalConfirmarBorrar").modal("hide");
      },

      cerrar() {
        this.alerta = false;
        this.alerta_eliminar = false;
        this.respuesta = '';
      }

    },

    computed: {
      //activar botón crear
      isDisabled: function () {
        if (this.title == "" || this.completed == "0" || this.userId == "") {
          return true;
        } else {
          return false;
        }
      },
      //activar botón eliminar
      isDisabledEditar: function () {
        if (this.title == "") {
          return true;
        } else {
          return false;
        }
      },
    },

    mounted() {
      this.listar();
    },
  };
</script>