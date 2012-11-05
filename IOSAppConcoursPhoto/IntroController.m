//
//  ViewController.m
//  IOSAppConcoursPhoto
//
//  Created by Kerautret on 22/10/12.
//  Copyright (c) 2012 projetTutoreSRC. All rights reserved.
//

#import "IntroController.h"

@interface IntroController ()

@end

@implementation IntroController

- (void)viewDidLoad
{

    [super viewDidLoad];
    myImageViewVerso = [[UIImageView alloc] initWithImage:[UIImage imageNamed:@"panneauPubVerso.png"]];
    
    
}



- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}





-(void) viewDidAppear:(BOOL)animated
{
    [NSThread sleepForTimeInterval: 2];
    [UIView transitionFromView: self.view
                        toView: myImageViewVerso
                        duration: 1.0f
                       options: UIViewAnimationOptionTransitionFlipFromLeft
                        completion: ^(BOOL done){
                        [NSThread sleepForTimeInterval: 2];
                        if(done){
                            self.view = myImageViewVerso;
                            [self performSegueWithIdentifier:@"MainController" sender:self];
                            
                        }
                    }];
   
}



@end
