/*!
* Start Bootstrap - Blog Home v5.0.9 (https://startbootstrap.com/template/blog-home)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-blog-home/blob/master/LICENSE)
*/
// This file is intentionally blank
// Use this file to add JavaScript to your project

let sections = document.querySelectorAll('section');
let navLinks = document.querySelectorAll('header nav a');

window.onscroll = () => {
  sections.forEach(sec => {
    let top = window.scrolly;
    let offset = window.offsetTop - 150;
    let height = window.offsetHeight;
    let id = window.getAttribute('id');

    if(top >= offset && top < offset + height){
      navLinks.forEach(links => {
          links.classList.remove('active');
          document.querySelector('header nav a [href*=' + id + ']').classList.add('active');
      })
    }

  })
}