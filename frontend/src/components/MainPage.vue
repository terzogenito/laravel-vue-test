<template>
  <div class="main-page">
    <!-- Menu Bar at the Top -->
    <nav class="menu-bar">
      <button
        @click="activeTab = 'home'"
        :class="{ active: activeTab === 'home' }"
        class="menu-button"
      >
        Home
      </button>

      <!-- Hovered Sub-Menu for Menu -->
      <div class="menu-item">
        <button :class="{ active: activeTab === 'menu' }" class="menu-button">Menu</button>
        <div class="submenu">
          <button @click="selectSubmenu('1')" :class="{ active: activeSubmenu === '1' }">
            Menu1
          </button>
          <button @click="selectSubmenu('2')" :class="{ active: activeSubmenu === '2' }">
            Menu2
          </button>
          <button @click="selectSubmenu('3')" :class="{ active: activeSubmenu === '3' }">
            Menu3
          </button>
        </div>
      </div>

      <button @click="confirmLogout" class="logout-button">Logout</button>
    </nav>

    <!-- Content Section Based on Active Tab -->
    <div class="content">
      <!-- Home Section with Accordion -->
      <div v-if="activeTab === 'home'">
        <h1>Home</h1>
        <p>Selamat datang di halaman utama!</p>

        <!-- Accordion Section -->
        <div class="accordion">
          <!-- Users Accordion -->
          <div class="accordion-item">
            <button
              @click="toggleAccordion('users')"
              :class="{ active: activeAccordion === 'users' }"
              class="accordion-button"
            >
              Users
            </button>
            <div v-if="activeAccordion === 'users'" class="accordion-content">
              <h2>Daftar Pengguna</h2>
              <table class="data-table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Role (Integer)</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="user in users" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.username }}</td>
                    <td>{{ user.role }}</td>
                    <td>
                      <button @click="editUser(user)" class="edit-button">Edit</button>
                      <button @click="confirmDelete(user.id, 'user')" class="delete-button">
                        Delete
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Menus Accordion -->
          <div class="accordion-item">
            <button
              @click="toggleAccordion('menus')"
              :class="{ active: activeAccordion === 'menus' }"
              class="accordion-button"
            >
              Menus
            </button>
            <div v-if="activeAccordion === 'menus'" class="accordion-content">
              <h2>Daftar Menus</h2>
              <!-- Table of Menus -->
              <table class="data-table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="menu in menus" :key="menu.id">
                    <td>{{ menu.id }}</td>
                    <td>{{ menu.name }}</td>
                    <td>{{ menu.role }}</td>
                    <td>
                      <button @click="editMenu(menu)" class="edit-button">Edit</button>
                      <button @click="confirmDelete(menu.id, 'menu')" class="delete-button">
                        Delete
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Trails Accordion -->
          <div class="accordion-item">
            <button
              @click="toggleAccordion('trails')"
              :class="{ active: activeAccordion === 'trails' }"
              class="accordion-button"
            >
              Trails
            </button>
            <div v-if="activeAccordion === 'trails'" class="accordion-content">
              <h2>Daftar Trails</h2>
              <!-- Table of Trails -->
              <table class="data-table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Menu ID</th>
                    <th>Method</th>
                    <th>Datetime</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="trail in trails" :key="trail.id">
                    <td>{{ trail.id }}</td>
                    <td>{{ trail.user_id }}</td>
                    <td>{{ trail.username }}</td>
                    <td>{{ trail.menu_id }}</td>
                    <td>{{ trail.method }}</td>
                    <td>{{ trail.datetime }}</td>
                    <td>
                      <button @click="editTrail(trail)" class="edit-button">Edit</button>
                      <button @click="confirmDelete(trail.id, 'trail')" class="delete-button">
                        Delete
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Menu Section with Dynamic Nested Menu -->
      <div v-if="activeTab === 'menu' && activeSubmenu === '1'">
        <h1>Menu1</h1>
        <p>Konten untuk Menu1.</p>
      </div>
      <div v-if="activeTab === 'menu' && activeSubmenu === '2'">
        <h1>Menu2</h1>
        <p>Konten untuk Menu2.</p>
      </div>
      <div v-if="activeTab === 'menu' && activeSubmenu === '3'">
        <h1>Menu3</h1>
        <p>Konten untuk Menu3.</p>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

export default {
  name: 'MainPage',
  methods: {
    async fetchUsers() {
      try {
        const response = await fetch("http://localhost:8000/api/users", {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
          },
        });
        if (!response.ok) throw new Error("Failed to fetch users");
        this.users = await response.json();
      } catch (error) {
        console.error(error);
      }
    },
  },
  watch: {
    activeTab(newTab) {
      if (newTab === "users") {
        this.fetchUsers(); // Fetch users when the tab is activated
      }
    },
  },
  setup() {
    const router = useRouter()
    const activeTab = ref('home')
    const activeAccordion = ref(null)
    const activeSubmenu = ref(null)

    // Sample data for Users, Menus, and Trails
    const users = ref([
      { id: 1, email: 'user1@example.com', username: 'user1', role: 1 },
      { id: 2, email: 'user2@example.com', username: 'user2', role: 2 },
      { id: 3, email: 'user3@example.com', username: 'user3', role: 3 },
    ])

    const menus = ref([
      { id: 1, name: 'Menu1', role: 1 },
      { id: 2, name: 'Menu2', role: 2 },
      { id: 3, name: 'Menu3', role: 3 },
    ])

    const trails = ref([
      {
        id: 1,
        user_id: 1,
        username: 'user1',
        menu_id: 1,
        method: 'GET',
        datetime: '2023-11-06 10:00',
      },
      {
        id: 2,
        user_id: 2,
        username: 'user2',
        menu_id: 2,
        method: 'POST',
        datetime: '2023-11-06 11:00',
      },
      {
        id: 3,
        user_id: 3,
        username: 'user3',
        menu_id: 3,
        method: 'DELETE',
        datetime: '2023-11-06 12:00',
      },
    ])

    const logout = () => {
      localStorage.removeItem('auth')
      router.push('/login')
    }

    const confirmLogout = () => {
      if (confirm('Apakah Anda yakin ingin logout?')) {
        logout()
      }
    }

    const toggleAccordion = (section) => {
      activeAccordion.value = activeAccordion.value === section ? null : section
    }

    const selectSubmenu = (submenu) => {
      activeTab.value = 'menu'
      activeSubmenu.value = submenu
    }

    const editUser = (user) => {
      alert(`Edit user: ${user.username}`)
    }

    const editMenu = (menu) => {
      alert(`Edit menu: ${menu.name}`)
    }

    const editTrail = (trail) => {
      alert(`Edit trail ID: ${trail.id}`)
    }

    const confirmDelete = (id, type) => {
      if (confirm(`Apakah Anda yakin ingin menghapus ${type} ini?`)) {
        deleteItem(id, type)
      }
    }

    const deleteItem = (id, type) => {
      if (type === 'user') {
        users.value = users.value.filter((user) => user.id !== id)
        alert(`User dengan ID ${id} telah dihapus.`)
      } else if (type === 'menu') {
        menus.value = menus.value.filter((menu) => menu.id !== id)
        alert(`Menu dengan ID ${id} telah dihapus.`)
      } else if (type === 'trail') {
        trails.value = trails.value.filter((trail) => trail.id !== id)
        alert(`Trail dengan ID ${id} telah dihapus.`)
      }
    }

    return {
      activeTab,
      activeAccordion,
      activeSubmenu,
      users,
      menus,
      trails,
      confirmLogout,
      toggleAccordion,
      selectSubmenu,
      editUser,
      editMenu,
      editTrail,
      confirmDelete,
    }
  },
}
</script>

<style scoped>
/* Main container */
.main-page {
  font-family: Arial, sans-serif;
}

.menu-bar {
  display: flex;
  justify-content: center;
  gap: 0;
  background-color: #f0f0f0;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  z-index: 1000;
}

.menu-button,
.logout-button {
  padding: 10px 15px;
  font-size: 14px;
  cursor: pointer;
  border: none;
  background-color: #e0e0e0;
  transition: background-color 0.3s;
  border-radius: 0;
}

.menu-button.active {
  background-color: #6e8efb;
  color: white;
}

.logout-button {
  color: white;
  background-color: #ff4d4d;
}

.logout-button:hover {
  background-color: #d13b3b;
}

.menu-button:hover {
  background-color: #c0c0c0;
}

.menu-item {
  position: relative;
}

.submenu {
  display: none;
  position: absolute;
  top: 100%;
  left: 0;
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  z-index: 1000;
  width: 100%;
}

.menu-item:hover .submenu {
  display: block;
}

.submenu button {
  width: 100%;
  padding: 10px;
  text-align: left;
  background: none;
  border: none;
  cursor: pointer;
}

.submenu button:hover {
  background-color: #e0e0e0;
}

.submenu button.active {
  background-color: #6e8efb;
  color: white;
}

.accordion {
  margin-top: 20px;
  text-align: left;
  width: 100%;
  max-width: 750px;
  margin: 0 auto;
}

.accordion-item {
  margin-bottom: 10px;
}

.accordion-button {
  width: 100%;
  padding: 10px;
  font-size: 16px;
  text-align: left;
  background-color: #e0e0e0;
  border: none;
  cursor: pointer;
  transition: background-color 0.3s;
}

.accordion-button.active {
  background-color: #6e8efb;
  color: white;
}

.accordion-content {
  padding: 10px;
  background-color: #f9f9f9;
  border: 1px solid #ddd;
}

.data-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.data-table th,
.data-table td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

.data-table th {
  background-color: #f0f0f0;
}

.edit-button {
  background-color: #6e8efb;
  color: white;
  padding: 5px 10px;
  border: none;
  cursor: pointer;
  margin-right: 5px;
}

.delete-button {
  background-color: #ff4d4d;
  color: white;
  padding: 5px 10px;
  border: none;
  cursor: pointer;
}

.edit-button:hover {
  background-color: #5b7cd6;
}

.delete-button:hover {
  background-color: #d13b3b;
}

.content {
  margin-top: 50px;
  text-align: center;
}

h1 {
  font-size: 24px;
  color: #333;
}
</style>
