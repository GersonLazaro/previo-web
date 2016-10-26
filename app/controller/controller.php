<?php
    /**
    * Previo II - Programación web
    * @author - Gerson Lázaro <gerson@hackerearth.com>
    * 1150972
    *
    * Clase abstracta generica utilitaria con las funciones comunes de los controladores.
    * Cada controlador extiende de esta clase. 
    */

    abstract class Controller {

        private $folderViews = 'app/view/';

        /**
		* Carga una plantilla para procesar la vista
		* @param $filename - Nombre del template a cargar (ubicado en la carpeta folderViews)
		* @return string con el valor html que debe ser mostrado
		*/
		public function getTemplate ($filename){
			return file_get_contents($this->folderViews . $filename);
		}
		
		/**
		*	Toma una vista y la muestra en pantalla en el cliente
		* 	@param $view - vista preconstruida para mostrar en el navegador
		*/
		public function showView ($view){
			echo $view;
		}


		/**
		*	Reemplaza un valor por otro en una cadena de texto. Utilizado para procesar las vistas
		* 	@param $view - Template donde se reemplazará el valor
		* 	@param $key - Cadena que será buscada en la $view
		*	@param $replace - Cadena con la que se reemplazará $key
		*	@return cadena sobreescrita
		*/
		public function renderView($view, $key, $replace){
			return str_replace($key, $replace, $view);
		}

        public function test() {
        }
    }