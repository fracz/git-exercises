## Pick your features
You have implemented three different features of a program in three different local topic branches.

          HEAD             ---- B - feature-b    
           |              /
    pick-your-features - Z <--- A - feature-a
                          \
                           ---- C1 <--- C2 - feature-c
                           
You want to have all these features as single commits in `pick-your-features` branch.

                        HEAD
                         |
                  pick-your-features
                         |
    Z <--- C <--- B <--- A
