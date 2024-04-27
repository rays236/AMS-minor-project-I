

public class ExceptTest {
    static void validate(int age) throws ArithmeticException{
        if (age<18) {
            throw new ArithmeticException("not valid age");
        }
        else{
            System.out.println("Welcome to vote");
        }
    }
    public static void main(String args[]){
        try{
            validate(12);
        }
        catch(ArithmeticException e){
            System.out.println(e);
        }
    }
}
