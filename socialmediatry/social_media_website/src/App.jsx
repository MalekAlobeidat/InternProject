import React, { useState } from 'react'
import { BrowserRouter,Routes,Route } from 'react-router-dom'
import HomePage from './components/HomePage'
import './App.css'
import Login from './components/Login'
import SignUp from './components/SignUp'
// import ShowAllPosts from './components/ShowAllPosts'

function App() {

  return (
    <>
    <BrowserRouter>
    <Routes>
      <Route path='HomePage' element={<HomePage/>}/>
      <Route path='Login' element={<Login/>}/>
      <Route path='AddpostMethod' element={<AddpostMethod/>}/>
      <Route path='SignUp' element={<SignUp/>}/>
      <Route path='Malek' element={<Malek/>}/>
      {/* <Route path='ShowAllPosts' element={<ShowAllPosts/>}/> */}
    </Routes>
    </BrowserRouter>

    </>
  )
}

export default App
