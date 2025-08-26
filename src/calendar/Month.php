<?php 

namespace Calendar;
	
	class Month {

		public $days =  ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

		private $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Jun', 'Juillet',
		'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

		public $month;
		public $year;
		
		/**
		* Month constructor
		*@param int $month le mois compris entre 1 et 12
		*@param int $year l'année
		*@throws \Exception
		*/
		
		public function __construct(?int $month = null, ?int $year = null) {

			if ($month === null) {
				$month = intval(date('m'));
			}

			if ($year === null) {
				$year = intval(date('Y'));
			}

			$this->month = $month;
			$this->year = $year;
		}
		
		/**
		 * Renvoie le pemier jour du mois.
		 * @return \DateTime
		 */
		public function getStartingDay () :\DateTime {
			return new \DateTime("{$this->year}-{$this->month}-01");
		}


		/**
		 * retourne le mois en toute lettre (ex: Février 2014)
		 * @return string
		 */

		public function toString(): string {
			return $this->months[$this->month - 1] . ' ' . $this->year;
		}

		/**
		 * renvoie le nombre de semaine dans le mois
		 * @return string
		 */

		public function getWeeks(): int {
			$start = $this->getStartingDay();
			$end = (clone $start)->modify('last day of this month');

			// Numéro de semaine ISO 8601
			$startWeek = intval($start->format('W'));
			$endWeek = intval($end->format('W'));

			// Cas particulier pour décembre / janvier
			if ($endWeek < $startWeek) {
				// Cela arrive si décembre finit en semaine 1 de l’année suivante
				$endWeek += intval((new \DateTime("{$this->year}-12-28"))->format('W'));
			}

			return $endWeek - $startWeek + 1;
		}

		/**
		 * Est ce-que le jour est dans le mois en cours
		 * @return \DateTime $date
		 * @return bool
		 */
		public function withInMonth (\DateTime $date): bool {
			return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
		}

		/**
		 * Renvoie le mois suivant
		 * @return Month
		 */

		public function nextMonth(): Month
		{
			$month = $this->month + 1;
			$year = $this->year;
			if($month > 12) {
				$month = 1;
				$year += 1;
			}
			return new Month($month, $year);
		}

		/**
		 * Renvoie le mois précédent
		 * @return Month
		 */

		public function previousMonth(): Month
		{
			$month = $this->month - 1;
			$year = $this->year;
			if($month < 1) {
				$month = 12;
				$year -= 1;
			}
			return new Month($month, $year);
		}
		
	}
	
 ?>