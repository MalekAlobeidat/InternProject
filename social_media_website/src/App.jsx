import React, { useState } from 'react'
import { BrowserRouter,Routes,Route } from 'react-router-dom'
import HomePage from './components/HomePage'
import AddpostMethod from './components/AddpostMethod'
import './App.css'
import Login from './components/Login'
import SignUp from './components/SignUp'

function App() {

  return (
    <>
    <BrowserRouter>
    <Routes>
      <Route path='HomePage' element={<HomePage/>}/>
      <Route path='Login' element={<Login/>}/>
      <Route path='AddpostMethod' element={<AddpostMethod/>}/>
      <Route path='SignUp' element={<SignUp/>}/>
    </Routes>
    </BrowserRouter>

    </>
  )
}

export default App
