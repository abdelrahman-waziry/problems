Array.prototype.top = function() {
    return this[this.length - 1]
}
var numbersQueue = []
var operatorsStack = []
var allowedOperators = ['/', '*', '+', '-']
var tokens = prompt('Please enter an expression')
for (let index = 0; index < tokens.length; index++) {
    var current = tokens[index]
    if(current === ' '){
        continue;
    }
    if(!isNaN(current)){
        numbersQueue.push(parseInt(current))
    }
    if(current === '('){
        operatorsStack.push(current)
    }

    // if there's a right bracket and the top of the operators stack doesn't close it, perfrom operation
    // then pop dismiss both brackts
    if(current === ')'){
        while(operatorsStack.top() !== '('){
            performOperation()
        }
        operatorsStack.pop()
    }
    
    // if operator is valid, perform operation while top of the operator stack has a 
    // higher precedence than the current, and push the current operator to the top of the stack
    if(allowedOperators.indexOf(current) !== -1){
        while(getPrecedence(operatorsStack.top()) >= getPrecedence(current)){
            performOperation() 
        }
        operatorsStack.push(current)
    }
}

// while there still operators in operators stack, perform operation
while(operatorsStack.length > 0){
    performOperation()
}

console.log(numbersQueue.pop())

function getPrecedence(operator){
    if(operator === '/' || operator === '*'){
        return 2
    }
    else if(operator === '+' || operator === '-'){
        return 1
    }
}

function performOperation(){
    // gets the last element of numbers queue and then the second last for both right and left sides
    let rightOp = numbersQueue.pop()
    let leftOp = numbersQueue.pop()
    // gets the last operator of the operators stack
    let operator = operatorsStack.pop()
    let result = calculate(leftOp !== undefined ? leftOp : null, rightOp, operator)
    // pushs new result to numbers queue
    numbersQueue.push(result)
}

function calculate(leftOp, rightOp, operator){
    if(operator === '+'){
        return leftOp + rightOp
    }
    else if(operator === '-'){
        return leftOp - rightOp
    }
    else if(operator === '/'){
        return leftOp / rightOp
    }
    else if(operator === '*'){
        return leftOp * rightOp
    }
}