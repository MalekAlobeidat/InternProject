    import React from 'react'
    import '../styles/login.css'
    import { useState } from 'react';

    function Login() {
        const [email, setEmail] = useState('');
        const [password, setPassword] = useState('');
      
        const handleSubmit = async (e) => {
          e.preventDefault();
      
          try {
            const response = await fetch('http://127.0.0.1:8000/api/login', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
              },
              body: JSON.stringify({ email, password }),
            });
      
            // Handle the response from the API
            if (response.ok) {
              const data = await response.json();
              console.log('Login successful', data);
              sessionStorage.setItem('RoldID' , data.user.RoleID)
              sessionStorage.setItem('token' , data.token)
              sessionStorage.setItem('userid' , data.user.id)
              window.location.href='HomePage'
              // Add any additional logic you need for a successful login
            } else {
              console.error('Login failed');
              // Handle the error, show a message to the user, etc.
            }
          } catch (error) {
            console.error('Error during login:', error);
          }
        };
    return (
        <div className='LogIn'>

        <form class="max-w-sm mx-auto" onSubmit={handleSubmit}>
        <div class="mb-5">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
            <input type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@flowbite.com" required
                value={email}
                onChange={(e) => setEmail(e.target.value)} />
        </div>
        <div class="mb-5">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
            <input type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required
             value={password}
             onChange={(e) => setPassword(e.target.value)}
             />
        </div>
        <div class="flex items-start mb-5">
            <div class="flex items-center h-5">
            </div>
            <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">         <span style={{color:"red"}}>Dont Have Account ? <a href='SignUp'>SignUp</a></span>
</label>
        </div>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </form>
        </div>
    )
    }

    export default Login