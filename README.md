# Newton

A car maintenance company “Newton Car Maintenance” wants to register the maintenance jobs it does on various cars, for various customers.
Some maintenance jobs are specific for a certain brand of car, or even a specific model of a car brand, others apply to all types of 
cars of all cars of a brand/model. Each maintenance job has a fixed rate in terms of service hours and may require certain spare parts.
Spare parts can also be generic for (almost) all cars, others are specific per brand or even per model. E.g., many cars share the same
engine block.

-----

# Setup (with Ddev)
## Git
The Newton project is setup using a main Git repository ([https://github.com/arthurGrinjo/Newton](https://github.com/arthurGrinjo/Newton)).
```
git clone --recursive git@github.com:arthurGrinjo/Newton.git
```
You'll end up with the following directory structure:

```
Newton
└─ .ddev
└─ Symfony - project folders
```

## DDEV
```
~/Newton$ ddev start
~/Newton$ ddev console doctrine:migrations:migrate (d:m:m)
~/Newton$ ddev console doctrine:fixtures:load (d:f:l)
```

## Commands
Generate amount of Scheduled Maintenance Jobs (max 100 per time)
Jobs are planned sequentially and add 15 minutes to each job to start/stop
```
~/Newton$ ddev console newton:jobs:load
```

Get Price overview for MaintenanceJobs per Job per Customer
```
~/Newton$ ddev console newton:jobs:calculate-price
```


# Assumptions
- Newton is opened from Tuesday - Saturday
- Each task takes a certain amount of quarters (15 min)
- Every engineer works 8 hours (32 quarters) a day
- Each timeslot describes the startday, starting quarter and ending quarter and can be ordered by the starting quarter
